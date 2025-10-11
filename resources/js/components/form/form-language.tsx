import { Combobox } from "@narsil-cms/blocks/fields";
import { type ComponentProps } from "react";

type FormLanguageProps = Omit<ComponentProps<typeof Combobox>, "id">;

function FormLanguage({ className, ...props }: FormLanguageProps) {
  return <Combobox data-slot="form-language" id="form-language" {...props} />;
}

export default FormLanguage;
