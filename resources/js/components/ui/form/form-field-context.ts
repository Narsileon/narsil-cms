import { createContext, useContext } from "react";

export type FormFieldContextProps = {
  error: string | undefined;
  handle: string;
};

export const FormFieldContext = createContext<FormFieldContextProps>({
  error: undefined,
  handle: "",
});

function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
