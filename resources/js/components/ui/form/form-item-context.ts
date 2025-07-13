import { createContext, useContext } from "react";

export type FormItemContextProps = {
  id: string;
};

export const FormItemContext = createContext<FormItemContextProps>({ id: "" });

function useFormItem() {
  const context = useContext(FormItemContext);

  if (!context) {
    throw new Error("useFormItem must be used within a FormItem.");
  }

  return context;
}

export default useFormItem;
