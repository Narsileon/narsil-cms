import { createContext, FormEvent, useContext } from "react";
import {
  InertiaFormProps,
  useForm as useFormPrimitive,
} from "@inertiajs/react";

export type ThemeProviderState = Partial<
  InertiaFormProps<Record<string, any>>
> & {
  onSubmit?: (event?: FormEvent) => void;
};

const FormProviderContext = createContext<ThemeProviderState>({
  data: {},
  errors: {},
  processing: false,
});

export type FormProps = React.ComponentProps<"form"> & {
  attributes: Record<string, any>;
  children: React.ReactNode;
  url: string;
};

function Form({ children, attributes, method, url, ...props }: FormProps) {
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
  } = useFormPrimitive(attributes);

  function onSubmit(event?: FormEvent) {
    event?.preventDefault();

    switch (method) {
      case "patch":
        patch(url);
        break;
      case "post":
        post(url);
        break;
      case "put":
        post(url);
        break;
    }
  }

  return (
    <FormProviderContext.Provider
      value={{
        data: data,
        errors: errors,
        isDirty: isDirty,
        processing: processing,
        cancel: cancel,
        clearErrors: clearErrors,
        onSubmit: onSubmit,
        patch: patch,
        post: post,
        put: put,
        reset: reset,
        setData: setData,
        setDefaults: setDefaults,
        setError: setError,
        submit: submit,

        transform: transform,
      }}
    >
      <form method={method} onSubmit={onSubmit} {...props}>
        {children}
      </form>
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

export default Form;
