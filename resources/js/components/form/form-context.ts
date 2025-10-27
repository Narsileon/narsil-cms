import { type InertiaFormProps } from "@inertiajs/react";
import { SelectOption } from "@narsil-cms/types";
import { createContext, useContext } from "react";

export type FormContextProps = Partial<InertiaFormProps<Record<string, unknown>>> & {
  action: string;
  defaultLanguage?: string;
  id: string;
  language: string;
  languageOptions: SelectOption[];
  method: string;
  setLanguage: (value: string) => void;
};

export const FormContext = createContext<FormContextProps>({
  action: "#",
  defaultLanguage: "en",
  id: "form",
  language: "en",
  languageOptions: [
    {
      label: "English",
      value: "en",
    },
  ],
  method: "post",
} as FormContextProps);

function useForm() {
  const context = useContext(FormContext);

  if (!context) {
    throw new Error("useForm must be used within a FormProvider.");
  }

  return context;
}

export default useForm;
