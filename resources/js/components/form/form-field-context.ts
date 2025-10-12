import type { Field } from "@narsil-cms/types";
import { createContext, useContext } from "react";

export type FormFieldContextProps = Field & {
  error: string | undefined;
  language: string;
  setLanguage: (value: string) => void;
};

export const FormFieldContext = createContext<FormFieldContextProps>({
  error: undefined,
  language: "en",
} as FormFieldContextProps);

function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
