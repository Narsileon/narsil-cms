import { FormContext } from "./form-context";
import { useForm } from "@inertiajs/react";
import type { FormContextProps } from "./form-context";

type FormProviderProps = {
  id: string;
  initialData?: Record<string, any>;
  render: (form: FormContextProps) => React.ReactNode;
};

function FormProvider({ id, initialData = {}, render }: FormProviderProps) {
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
  } = useForm(initialData);

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
