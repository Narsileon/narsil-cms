import * as React from "react";
import { Field } from "@narsil-cms/types/forms";
export type FormFieldContextProps = Field & {
  error: string | undefined;
};

export const FormFieldContext = React.createContext<FormFieldContextProps>({
  error: undefined,
} as FormFieldContextProps);

function useFormField() {
  const context = React.useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
