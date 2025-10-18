import { Select } from "@narsil-cms/blocks/fields";
import { type ComponentProps } from "react";
import useForm from "./form-context";

type FormLanguageProps = Omit<ComponentProps<typeof Select>, "options">;

function FormLanguage({ ...props }: FormLanguageProps) {
  const { languageOptions } = useForm();

  return languageOptions?.length > 0 ? (
    <Select data-slot="form-language" options={languageOptions} {...props} />
  ) : null;
}

export default FormLanguage;
