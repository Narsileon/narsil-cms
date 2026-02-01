import { Combobox } from "@base-ui/react";

function ComboboxPortal({ ...props }: Combobox.Portal.Props) {
  return <Combobox.Portal data-slot="combobox-portal" {...props} />;
}

export default ComboboxPortal;
