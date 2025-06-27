import { createContext, useContext } from "react";
import {
  InertiaFormProps,
  useForm as useFormPrimitive,
} from "@inertiajs/react";

export type ThemeProviderState = Partial<
  InertiaFormProps<Record<string, any>>
> & {
  id: string;
};

const FormProviderContext = createContext<ThemeProviderState>({
  id: "form",
});

export type FormProviderProps = {
  id: string;
  initialData?: Record<string, any>;
  render: (form: ThemeProviderState) => React.ReactNode;
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
  } = useFormPrimitive(initialData);

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
    <FormProviderContext.Provider value={value}>
      {render(value)}
    </FormProviderContext.Provider>
  );
}

export function useForm() {
  const context = useContext(FormProviderContext);

  if (!context) {
    throw new Error("useForm must be used within a Form");
  }

  return context;
}

export default FormProvider;
