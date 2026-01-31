import { Select } from "@base-ui/react/select";

function SelectPortal({ ...props }: Select.Portal.Props) {
  return <Select.Portal data-slot="select-portal" {...props} />;
}

export default SelectPortal;
