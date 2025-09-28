import { cloneDeep, get, unset } from "lodash";
import { useEffect, useState } from "react";

import type { BlockElementCondition, Field } from "@narsil-cms/types";

import useForm from "./form-context";
import { FormFieldContext } from "./form-field-context";

type FormFieldProps = {
  conditions?: BlockElementCondition[];
  field: Field;
  id: string;
  render: (field: {
    handle: string;
    value: unknown;
    onFieldChange: (value: unknown) => void;
  }) => React.ReactNode;
};

const FormField = ({ conditions, field, id, render }: FormFieldProps) => {
  const [visible, setVisible] = useState(true);

  const { data, errors, setData } = useForm();
  const { settings } = field;

  const value = get(data, id);
  const error = get(errors, id);

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
      setData?.((data: Record<string, unknown>) => {
        const newData = cloneDeep(data);

        unset(newData, field.handle);

        return newData;
      });

      setVisible(false);
    }
  }, [data]);

  return visible ? (
    <FormFieldContext.Provider value={{ ...field, error: error }}>
      {render({
        handle: id,
        value: value ?? settings?.value ?? "",
        onFieldChange: (value) => {
          setData?.(id, value);
        },
      })}
    </FormFieldContext.Provider>
  ) : null;
};

export default FormField;
