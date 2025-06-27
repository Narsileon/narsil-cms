import { createContext, FormEvent, useContext } from "react";
import { VisitOptions } from "@inertiajs/core";
import {
  InertiaFormProps,
  useForm as useFormPrimitive,
} from "@inertiajs/react";

export type ThemeProviderState = Partial<
  InertiaFormProps<Record<string, any>>
> & {
  id: string;
  onSubmit?: (e?: FormEvent) => void;
};

const FormProviderContext = createContext<ThemeProviderState>({
  id: "form",
  data: {},
  errors: {},
  processing: false,
});

export type FormProps = React.ComponentProps<"form"> & {
  attributes?: Record<string, any>;
  children: React.ReactNode;
  options?: Omit<VisitOptions, "data">;
  url: string;
};

function Form({
  attributes = {},
  children,
  id = "form",
  method = "post",
  options,
  url,
  ...props
}: FormProps) {
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

  function onSubmit(e?: FormEvent) {
    e?.preventDefault();

    switch (method) {
      case "patch":
        patch(url, options);
        break;
      case "post":
        post(url, options);
        break;
      case "put":
        put(url, options);
        break;
    }
  }

  return (
    <FormProviderContext.Provider
      value={{
        id: id,
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
      <form id={id} method={method} onSubmit={onSubmit} {...props}>
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
