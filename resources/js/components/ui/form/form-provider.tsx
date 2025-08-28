import * as React from "react";
import { FormContext } from "./form-context";
import { useForm } from "@inertiajs/react";
import type { Block, Field } from "@narsil-cms/types/forms";
import type { FormContextProps } from "./form-context";

type FormProviderProps = {
  elements?: (Field | Block)[];
  id: string;
  initialValues?: Record<string, any>;
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  elements = [],
  id,
  initialValues = {},
  render,
}: FormProviderProps) {
  function flattenValues(elements: (Field | Block)[]): Record<string, any> {
    const receivedValues: Record<string, any> = {};

    elements.map((element) => {
      if ("elements" in element) {
        element.elements?.map((blockElement) => {
          const childElement = blockElement.element;

          if ("elements" in childElement) {
            Object.assign(receivedValues, flattenValues([childElement]));
          } else if ("type" in childElement) {
            receivedValues[blockElement.handle] =
              childElement.settings?.value ?? "";
          }
        });
      } else if ("type" in element) {
        receivedValues[element.handle] = element.settings?.value ?? "";
      }
    });

    return receivedValues;
  }

  const mergedInitialValues = Object.assign(
    flattenValues(elements),
    initialValues,
  );

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

  const value = {
    id: id,
    data: data,
    errors: errors,
    isDirty: isDirty,
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
    submit: submit,
    transform: transform,
  };

  return (
    <FormContext.Provider value={value}>{render(value)}</FormContext.Provider>
  );
}

export default FormProvider;
