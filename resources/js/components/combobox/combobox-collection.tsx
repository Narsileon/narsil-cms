import { Combobox } from "@base-ui/react";

function ComboboxCollection({ ...props }: Combobox.Collection.Props) {
  return <Combobox.Collection data-slot="combobox-collection" {...props} />;
}

export default ComboboxCollection;
