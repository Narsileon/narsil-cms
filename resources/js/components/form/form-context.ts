import { type InertiaFormProps } from "@inertiajs/react";
import { createContext, useContext } from "react";

export type FormContextProps = Partial<
  InertiaFormProps<Record<string, unknown>>
> & {
  action: string;
  id: string;
  method: string;
};

export const FormContext = createContext<FormContextProps>({
  action: "#",
  id: "form",
  method: "post",
});

function useForm() {
  const context = useContext(FormContext);

  if (!context) {
    throw new Error("useForm must be used within a FormProvider.");
  }

  return context;
}

export default useForm;
