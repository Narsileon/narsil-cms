import { Combobox } from "@base-ui/react";

function ComboboxGroup({ ...props }: Combobox.Group.Props) {
  return <Combobox.Group data-slot="combobox-group" {...props} />;
}

export default ComboboxGroup;
