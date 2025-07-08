import { FormFieldContext } from "./form-field-context";
import useForm from "./form-context";

type FormFieldContextProps = { error: string | undefined; name: string };

type FormFieldProps = {
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

export default FormField;
