import { FormContext } from "./form-context";
import { useForm } from "@inertiajs/react";
import type { FieldType } from "@narsil-cms/types/forms";
import type { FormContextProps } from "./form-context";

type FormProviderProps = {
  fields?: FieldType[];
  id: string;
  initialValues?: Record<string, any>;
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  fields = [],
  id,
  initialValues = {},
  render,
}: FormProviderProps) {
  function flattenFields(fields: FieldType[]): FieldType[] {
    return fields.flatMap((field) =>
      field.fields && field.fields.length > 0
        ? flattenFields(field.fields)
        : [field],
    );
  }

  const mergedInitialValues = Object.assign(
    Object.fromEntries(
      flattenFields(fields).map(({ handle, settings }) => [
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
