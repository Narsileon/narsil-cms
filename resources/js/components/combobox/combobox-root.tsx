import { Combobox } from "@base-ui/react";

function ComboboxRoot({ ...props }: Combobox.Root.Props<unknown>) {
  return <Combobox.Root data-slot="combobox-root" {...props} />;
}

export default ComboboxRoot;
