import { FormFieldContext } from "./form-field-context";
import useForm from "./form-context";

type FormFieldProps = {
  handle: string;
  render: (field: {
    handle: string;
    value: any;
    onFieldChange: (value: any) => void;
  }) => React.ReactNode;
};

const FormField = ({ handle, render }: FormFieldProps) => {
  const { data, errors, setData } = useForm();

  const error = errors?.[handle];

  return (
    <FormFieldContext.Provider value={{ error: error, handle: handle }}>
      {render({
        handle: handle,
        value: data?.[handle] ?? "",
        onFieldChange: (value) => setData?.(handle, value),
      })}
    </FormFieldContext.Provider>
  );
};

export default FormField;
