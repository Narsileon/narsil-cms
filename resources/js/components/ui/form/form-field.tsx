import { createContext, useContext } from "react";
import { useForm } from "./form";

export type FormFieldState = { error: string | undefined; name: string };

const FormFieldContext = createContext<FormFieldState>({
  error: undefined,
  name: "",
});

export type FormFieldProps = {
  name: string;
  render: (field: {
    id: string;
    value: any;
    onChange: (value: any) => void;
  }) => React.ReactNode;
};

const FormField = ({ name, render }: FormFieldProps) => {
  const { data, errors, setData } = useForm();

  const error = errors?.[name];

  return (
    <FormFieldContext.Provider value={{ error: error, name: name }}>
      {render({
        id: name,
        value: data?.[name] ?? "",
        onChange: (value) => setData?.(name, value),
      })}
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
