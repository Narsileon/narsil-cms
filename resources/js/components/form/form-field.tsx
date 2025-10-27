import type { BlockElementCondition, Field } from "@narsil-cms/types";
import { cloneDeep, get, isObject, unset } from "lodash";
import { useEffect, useState } from "react";
import useForm from "./form-context";
import { FormFieldContext } from "./form-field-context";

type FormFieldProps = {
  conditions?: BlockElementCondition[];
  field: Field;
  id: string;
  render: (field: {
    fieldLanguage: string;
    handle: string;
    placeholder?: string;
    value: unknown;
    onFieldChange: (value: unknown) => void;
    setFieldLanguage: (value: string) => void;
  }) => React.ReactNode;
};

function FormField({ conditions, field, id, render }: FormFieldProps) {
  const { data, defaultLanguage, errors, formLanguage, setData } = useForm();

  const [fieldLanguage, setFieldLanguage] = useState<string>("en");
  const [visible, setVisible] = useState<boolean>(true);

  const error = get(errors, id);

  function getPlaceholder() {
    let placeholder = undefined;

    if (field.translatable && defaultLanguage) {
      const value = get(data, id);

      if (isObject(value)) {
        placeholder = get(value, defaultLanguage);
      }
    }

    return placeholder;
  }

  function getValue() {
    const defaultValue = (field.settings as Record<string, unknown>)?.value ?? "";

    let value = get(data, id, defaultValue);

    if (field.translatable && isObject(value)) {
      value = get(value, fieldLanguage, defaultValue);
    }

    return value;
  }

  useEffect(() => {
    let nextVisible = true;

    for (const condition of conditions || []) {
      if (data?.[condition.target_id] !== condition.value) {
        nextVisible = false;
        break;
      }
    }

    if (nextVisible && !visible) {
      setVisible(true);
    } else if (!nextVisible && visible) {
      setData?.((data: Record<string, unknown>) => {
        const newData = cloneDeep(data);

        unset(newData, field.handle);

        return newData;
      });

      setVisible(false);
    }
  }, [data]);

  useEffect(() => {
    setFieldLanguage(formLanguage);
  }, [formLanguage]);

  const contextValue = {
    ...field,
    error: error,
    fieldLanguage: fieldLanguage,
    setFieldLanguage: setFieldLanguage,
  };

  return visible ? (
    <FormFieldContext.Provider value={contextValue}>
      {render({
        handle: id,
        fieldLanguage: fieldLanguage,
        placeholder: getPlaceholder(),
        value: getValue(),
        onFieldChange: (value) => {
          const key = field.translatable ? `${id}.${fieldLanguage}` : id;

          setData?.(key, value);
        },
        setFieldLanguage: setFieldLanguage,
      })}
    </FormFieldContext.Provider>
  ) : null;
}

export default FormField;
