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
    handle: string;
    language: string;
    value: unknown;
    onFieldChange: (value: unknown) => void;
    setLanguage: (value: string) => void;
  }) => React.ReactNode;
};

function FormField({ conditions, field, id, render }: FormFieldProps) {
  const { data, errors, language: formLanguage, setData } = useForm();

  const [language, setLanguage] = useState<string>("en");
  const [visible, setVisible] = useState<boolean>(true);

  const error = get(errors, id);

  function getValue() {
    const defaultValue = (field.settings as Record<string, unknown>)?.value ?? "";
    let value = get(data, id, defaultValue);

    if (field.translatable && isObject(value)) {
      value = get(value, language, defaultValue);
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
    setLanguage(formLanguage);
  }, [formLanguage]);

  const contextValue = {
    ...field,
    error: error,
    language: language,
    setLanguage: setLanguage,
  };

  return visible ? (
    <FormFieldContext.Provider value={contextValue}>
      {render({
        handle: id,
        language: language,
        value: getValue(),
        onFieldChange: (value) => {
          const key = field.translatable ? `${id}.${language}` : id;

          setData?.(key, value);
        },
        setLanguage: setLanguage,
      })}
    </FormFieldContext.Provider>
  ) : null;
}

export default FormField;
