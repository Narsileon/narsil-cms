import { createContext, useContext } from "react";

export type FormFieldContextProps = {
  error: string | undefined;
  fieldLanguage: string;
  handle: string;
  setFieldLanguage: (value: string) => void;
};

export const FormFieldContext = createContext<FormFieldContextProps>({
  error: undefined,
  fieldLanguage: "en",
  handle: "",
} as FormFieldContextProps);

function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
