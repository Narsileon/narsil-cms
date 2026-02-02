import { Combobox } from "@base-ui/react";

function ComboboxInput({ ...props }: Combobox.Input.Props) {
  return <Combobox.Input data-slot="combobox-input" {...props} />;
}

export default ComboboxInput;
