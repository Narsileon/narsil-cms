import { Combobox } from "@narsil-cms/blocks/fields";
import { type ComponentProps } from "react";

type FormLanguageProps = ComponentProps<"input">;

function FormLanguage({ className, type, ...props }: FormLanguageProps) {
  return <Combobox data-slot="input-language" {...props} />;
}

export default FormLanguage;
