import { FormFieldContext } from "./form-field-context";
import { useEffect, useState } from "react";
import useForm from "./form-context";
import type { FieldType } from "@narsil-cms/types/forms";

type FormFieldProps = {
  field: FieldType;
  render: (field: {
    handle: string;
    value: any;
    onFieldChange: (value: any) => void;
  }) => React.ReactNode;
};

const FormField = ({ field, render }: FormFieldProps) => {
  const [visible, setVisible] = useState(true);

  const { data, errors, setData } = useForm();
  const { handle, conditions, settings, visibility } = field;

  const error = errors?.[handle];

  useEffect(() => {
    if (!visibility) {
      return;
    }

    if (visibility === "hidden") {
      setVisible(false);
    }

    if (visibility !== "display") {
      if (!conditions || conditions.length === 0) {
        setVisible(false);
      } else {
        conditions.map((condition) => {
          if (data?.[condition.target_id] !== condition.value) {
            setVisible(false);
          } else {
            setVisible(true);
          }
        });
      }
    }
  }, [data, visibility]);

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
