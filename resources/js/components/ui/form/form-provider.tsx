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
  function flattenFields(elements: (Field | Block)[]): Field[] {
    const fields: Field[] = [];

    for (const element of elements) {
      if ("elements" in element) {
        for (const blockElement of element.elements) {
          const childElement = blockElement.element;

          if ("elements" in childElement) {
            fields.push(...flattenFields([childElement]));
          } else if (childElement.handle && childElement.type) {
            fields.push(childElement);
          }
        }
      } else if (element.handle && element.type) {
        fields.push(element);
      }
    }

    return fields;
  }

  const mergedInitialValues = Object.assign(
    Object.fromEntries(
      flattenFields(elements).map(({ handle, settings }) => [
        handle,
        settings?.value ?? settings?.checked ?? "",
      ]),
    ),
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
