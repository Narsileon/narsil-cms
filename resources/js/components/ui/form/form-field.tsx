import { FormFieldContext } from "./form-field-context";
import { useEffect, useState } from "react";
import useForm from "./form-context";
import type { BlockElementCondition, Field } from "@narsil-cms/types/forms";

type FormFieldProps = {
  conditions?: BlockElementCondition[];
  field: Field;
  render: (field: {
    handle: string;
    value: any;
    onFieldChange: (value: any) => void;
  }) => React.ReactNode;
};

const FormField = ({ conditions, field, render }: FormFieldProps) => {
  const [visible, setVisible] = useState(true);

  const { data, errors, setData } = useForm();
  const { handle, settings } = field;

  const error = errors?.[handle];

  useEffect(() => {
    conditions?.map((condition) => {
      if (data?.[condition.target_id] !== condition.value) {
        setVisible(false);
      } else {
        setVisible(true);
      }
    });
  }, [data]);

  return visible ? (
    <FormFieldContext.Provider value={{ error: error, ...field }}>
      {render({
        handle: handle,
        value: data?.[handle] ?? settings?.value ?? "",
        onFieldChange: (value) => {
          setData?.(handle, value);
        },
      })}
    </FormFieldContext.Provider>
  ) : null;
};

export default FormField;
