import { createContext, useContext } from "react";

type FormFieldContextProps = { error: string | undefined; name: string };

export const FormFieldContext = createContext<FormFieldContextProps>({
  error: undefined,
  name: "",
});

function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField.");
  }

  return context;
}

export default useFormField;
