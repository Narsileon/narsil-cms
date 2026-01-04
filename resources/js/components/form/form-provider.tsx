import { useForm } from "@inertiajs/react";
import { getFieldDefaultValue } from "@narsil-cms/lib/field";
import type { Block, Field, SelectOption, TemplateTab } from "@narsil-cms/types";
import { set } from "lodash-es";
import { useState } from "react";
import { FormContext, type FormContextProps } from "./form-context";

type FormProviderProps = {
  action: string;
  defaultLanguage?: string;
  elements?: (Block | Field | TemplateTab)[];
  id: string;
  initialValues?: Record<string, unknown>;
  languageOptions?: SelectOption[];
  method: string;
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  action,
  defaultLanguage,
  elements = [],
  id,
  initialValues = {},
  languageOptions = [],
  method,
  render,
}: FormProviderProps) {
  const [formLanguage, setFormLanguage] = useState<string>("en");

  function flattenValues(elements: (Block | Field | TemplateTab)[]): Record<string, unknown> {
    const receivedValues: Record<string, unknown> = {};

    elements.map((element) => {
      if ("elements" in element) {
        element.elements?.map((hasElement) => {
          const childElement = hasElement.element;

          if ("elements" in childElement) {
            Object.assign(receivedValues, flattenValues([childElement]));
          } else if ("type" in childElement) {
            set(receivedValues, hasElement.handle, getFieldDefaultValue(childElement));
          }
        });
      } else if ("type" in element) {
        set(receivedValues, element.handle, getFieldDefaultValue(element as Field));
      }
    });

    return receivedValues;
  }

  const mergedInitialValues = Object.assign(flattenValues(elements), initialValues);

  const {
    data,
    errors,
    isDirty,
    processing,
    cancel,
    clearErrors,
    patch,
    post,
    put,
    reset,
    setData,
    setDefaults,
    setError,
    submit,
    transform,
  } = useForm<Record<string, any>>(mergedInitialValues);

  const contextValue = {
    action: action,
    data: data,
    defaultLanguage: defaultLanguage,
    errors: errors,
    formLanguage: formLanguage,
    id: id,
    isDirty: isDirty,
    languageOptions: languageOptions,
    method: method,
    processing: processing,
    cancel: cancel,
    clearErrors: clearErrors,
    patch: patch,
    post: post,
    put: put,
    reset: reset,
    setData: setData,
    setDefaults: setDefaults,
    setError: setError,
    setFormLanguage: setFormLanguage,
    submit: submit,
    transform: transform,
  };

  return <FormContext.Provider value={contextValue}>{render(contextValue)}</FormContext.Provider>;
}

export default FormProvider;
