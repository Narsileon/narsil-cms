import * as React from "react";
import type { InertiaFormProps } from "@inertiajs/react";

export type FormContextProps = Partial<
  InertiaFormProps<Record<string, any>>
> & {
  id: string;
};

export const FormContext = React.createContext<FormContextProps>({
  id: "form",
});

function useForm() {
  const context = React.useContext(FormContext);

  if (!context) {
    throw new Error("useForm must be used within a FormProvider.");
  }

  return context;
}

export default useForm;
