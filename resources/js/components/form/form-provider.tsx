import { useForm } from "@inertiajs/react";
import type { Block, Field, TemplateSection } from "@narsil-cms/types";
import { useState } from "react";
import { FormContext, type FormContextProps } from "./form-context";

type FormProviderProps = {
  action: string;
  elements?: (Block | Field | TemplateSection)[];
  id: string;
  initialValues?: Record<string, unknown>;
  method: string;
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  action,
  elements = [],
  id,
  initialValues = {},
  method,
  render,
}: FormProviderProps) {
  const [language, setLanguage] = useState<string>("en");

  function flattenValues(elements: (Field | Block)[]): Record<string, unknown> {
    const receivedValues: Record<string, unknown> = {};

    elements.map((element) => {
      if ("elements" in element) {
        element.elements?.map((blockElement) => {
          const childElement = blockElement.element;

          if ("elements" in childElement) {
            Object.assign(receivedValues, flattenValues([childElement]));
          } else if ("type" in childElement) {
            receivedValues[blockElement.handle] = childElement.settings?.value ?? "";
          }
        });
      } else if ("type" in element) {
        receivedValues[element.handle] = element.settings?.value ?? "";
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
    errors: errors,
    id: id,
    isDirty: isDirty,
    language: language,
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
    setLanguage: setLanguage,
    submit: submit,
    transform: transform,
  };

  return <FormContext.Provider value={contextValue}>{render(contextValue)}</FormContext.Provider>;
}

export default FormProvider;
