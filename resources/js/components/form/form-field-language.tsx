import { Select } from "@narsil-cms/blocks/fields/select";
import { type ComponentProps } from "react";
import useForm from "./form-context";

type FormFieldLanguageProps = Omit<ComponentProps<typeof Select>, "options">;

function FormFieldLanguage({ ...props }: FormFieldLanguageProps) {
  const { languageOptions } = useForm();

  return languageOptions?.length > 0 ? (
    <Select data-slot="form-language" options={languageOptions} {...props} />
  ) : null;
}

export default FormFieldLanguage;
