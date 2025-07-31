import { cloneDeep, get, unset } from "lodash";
import { FormFieldContext } from "./form-field-context";
import { useEffect, useState } from "react";
import type { BlockElementCondition, Field } from "@narsil-cms/types/forms";
import useForm from "./form-context";

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

  const error = get(errors, handle);

  useEffect(() => {
    let nextVisible = true;

    for (const condition of conditions || []) {
      if (data?.[condition.target_id] !== condition.value) {
        nextVisible = false;
        break;
      }
    }

    if (nextVisible && !visible) {
      setVisible(true);
    } else if (!nextVisible && visible) {
      setData?.((data: Record<string, any>) => {
        const newData = cloneDeep(data);

        unset(newData, field.handle);

        return newData;
      });

      setVisible(false);
    }
  }, [data]);

  return visible ? (
    <FormFieldContext.Provider value={{ error: error, ...field }}>
      {render({
        handle: handle,
        value: get(data, handle) ?? settings?.value ?? "",
        onFieldChange: (value) => {
          setData?.(handle, value);
        },
      })}
    </FormFieldContext.Provider>
  ) : null;
};

export default FormField;
