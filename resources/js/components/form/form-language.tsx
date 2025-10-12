import { Select } from "@narsil-cms/blocks/fields";
import { type ComponentProps } from "react";
import useForm from "./form-context";

type FormLanguageProps = Omit<ComponentProps<typeof Select>, "options">;

function FormLanguage({ ...props }: FormLanguageProps) {
  const { languageOptions } = useForm();

  return <Select data-slot="form-language" options={languageOptions} {...props} />;
}

export default FormLanguage;
