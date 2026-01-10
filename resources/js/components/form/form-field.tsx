import { replaceLastPath } from "@narsil-cms/lib/utils";
import type { Element } from "@narsil-cms/types";
import { cloneDeep, get, isObject, unset } from "lodash-es";
import { useEffect, useState } from "react";
import useForm from "./form-context";
import { FormFieldContext } from "./form-field-context";

type FormFieldProps = Element & {
  render: (field: {
    fieldLanguage: string;
    handle: string;
    placeholder?: string;
    value: unknown;
    onFieldChange: (value: unknown) => void;
    setFieldLanguage: (value: string) => void;
  }) => React.ReactNode;
};

function FormField({ base, conditions, handle, render, translatable }: FormFieldProps) {
  const { data, defaultLanguage, errors, formLanguage, setData } = useForm();

  const [fieldLanguage, setFieldLanguage] = useState<string>("en");
  const [visible, setVisible] = useState<boolean>(true);

  function getError() {
    let error = get(errors, handle);

    if (!error && translatable) {
      error = get(errors, `${handle}.${fieldLanguage}`);
    }

    return error;
  }

  function getPlaceholder() {
    let placeholder = undefined;

    if (translatable && defaultLanguage) {
      const value = get(data, handle);

      if (isObject(value)) {
        placeholder = get(value, defaultLanguage);
      }
    }

    return placeholder;
  }

  function getValue() {
    const defaultValue = (base.settings as Record<string, unknown>)?.value ?? "";

    let value = get(data, handle, defaultValue);

    if (translatable && isObject(value)) {
      value = get(value, fieldLanguage, defaultValue);
    }

    return value;
  }

  useEffect(() => {
    if (get(data, handle) === undefined) {
      setData?.(handle, getValue());
    }
  }, []);

  useEffect(() => {
    let nextVisible = true;

    for (const condition of conditions || []) {
      if (get(data, replaceLastPath(handle, condition.handle)) !== condition.value) {
        nextVisible = false;
        break;
      }
    }

    if (nextVisible && !visible) {
      setVisible(true);
    } else if (!nextVisible && visible) {
      setData?.((data: Record<string, unknown>) => {
        const newData = cloneDeep(data);

        unset(newData, handle);

        return newData;
      });

      setVisible(false);
    }
  }, [data]);

  useEffect(() => {
    requestAnimationFrame(() => {
      setFieldLanguage(formLanguage);
    });
  }, [formLanguage]);

  const contextValue = {
    ...base,
    error: getError(),
    fieldLanguage: fieldLanguage,
    setFieldLanguage: setFieldLanguage,
  };

  return visible ? (
    <FormFieldContext.Provider value={contextValue}>
      {render({
        handle: handle,
        fieldLanguage: fieldLanguage,
        placeholder: getPlaceholder(),
        value: getValue(),
        onFieldChange: (value) => {
          const key = translatable ? `${handle}.${fieldLanguage}` : handle;

          setData?.(key, value);
        },
        setFieldLanguage: setFieldLanguage,
      })}
    </FormFieldContext.Provider>
  ) : null;
}

export default FormField;
