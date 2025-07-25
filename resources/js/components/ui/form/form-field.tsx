import { FormFieldContext } from "./form-field-context";
import { useEffect, useState } from "react";
import useForm from "./form-context";
import type { Field, FieldCondition } from "@narsil-cms/types/models";

type FormFieldProps = {
  conditions?: FieldCondition[] | null;
  handle: string;
  visibility: Field["visibility"];
  render: (field: {
    handle: string;
    value: any;
    onFieldChange: (value: any) => void;
  }) => React.ReactNode;
};

const FormField = ({
  conditions = null,
  handle,
  visibility = "display",
  render,
}: FormFieldProps) => {
  const [visible, setVisible] = useState(true);

  const { data, errors, setData } = useForm();

  const error = errors?.[handle];
  console.log(conditions);
  useEffect(() => {
    if (visibility === "hidden") {
      setVisible(false);
    }

    if (visibility !== "display") {
      if (!conditions || conditions.length === 0) {
        setVisible(false);
      } else {
        conditions.map((condition) => {
          console.log(data?.[condition.target_id]);
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
    <FormFieldContext.Provider value={{ error: error, handle: handle }}>
      {render({
        handle: handle,
        value: data?.[handle] ?? "",
        onFieldChange: (value) => setData?.(handle, value),
      })}
    </FormFieldContext.Provider>
  ) : null;
};

export default FormField;
