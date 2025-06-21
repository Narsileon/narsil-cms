import { createContext, useContext } from "react";
import { useForm } from "./form";

export type FormFieldState = { error: string | undefined; name: string };

const FormFieldContext = createContext<FormFieldState>({
  error: undefined,
  name: "",
});

export type FormFieldProps = {
  children: React.ReactNode;
  name: string;
};

const FormField = ({ children, name }: FormFieldProps) => {
  const { errors } = useForm();

  const error = errors?.[name];

  return (
    <FormFieldContext.Provider value={{ error: error, name: name }}>
      {children}
    </FormFieldContext.Provider>
  );
};

export function useFormField() {
  const context = useContext(FormFieldContext);

  if (!context) {
    throw new Error("useFormField must be used within a FormField");
  }

  return context;
}

export default FormField;
