import { createContext, useContext } from "react";

import { Field } from "@narsil-cms/types";

export type FormFieldContextProps = Field & {
  error: string | undefined;
};

export const FormFieldContext = createContext<FormFieldContextProps>({
  error: undefined,
} as FormFieldContextProps);

function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
