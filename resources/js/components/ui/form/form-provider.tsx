import { FormContext } from "./form-context";
import { useForm } from "@inertiajs/react";
import type { FieldSetType, FieldType } from "@narsil-cms/types/forms";
import type { FormContextProps } from "./form-context";

type FormProviderProps = {
  id: string;
  initialValues?: Record<string, any>;
  items?: (FieldType | FieldSetType)[];
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  items = [],
  id,
  initialValues = {},
  render,
}: FormProviderProps) {
  function flattenFields(items: (FieldType | FieldSetType)[]): FieldType[] {
    return items.flatMap((item) =>
      "items" in item ? flattenFields(item.items) : [item],
    );
  }

  const mergedInitialValues = Object.assign(
    Object.fromEntries(
      flattenFields(items).map(({ handle, settings }) => [
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
