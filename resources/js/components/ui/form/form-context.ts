import { createContext, useContext } from "react";
import type { InertiaFormProps } from "@inertiajs/react";

type FormContextProps = Partial<InertiaFormProps<Record<string, any>>> & {
  id: string;
};

export const FormContext = createContext<FormContextProps>({
  id: "form",
});

function useForm() {
  const context = useContext(FormContext);

  if (!context) {
    throw new Error("useForm must be used within a FormProvider.");
  }

  return context;
}

export default useForm;
