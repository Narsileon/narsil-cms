import { Combobox } from "@base-ui/react";

function ComboboxValue({ ...props }: Combobox.Value.Props) {
  return <Combobox.Value data-slot="combobox-value" {...props} />;
}

export default ComboboxValue;
