import { FormContext } from "./form-context";
import { useForm } from "@inertiajs/react";
import type { FormContextProps } from "./form-context";
import type { LaravelFormInput } from "@/types/global";

type FormProviderProps = {
  initialValues?: Record<string, any>;
  id: string;
  inputs?: LaravelFormInput[];
  render: (props: FormContextProps) => React.ReactNode;
};

function FormProvider({
  initialValues = {},
  id,
  inputs = [],
  render,
}: FormProviderProps) {
  const mergedInitialValues = Object.assign(
    Object.fromEntries(inputs.map(({ id, value }) => [id, value])),
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
