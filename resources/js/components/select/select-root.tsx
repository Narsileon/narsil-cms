import { Select } from "@base-ui/react/select";

function SelectRoot({ ...props }: Select.Root.Props<unknown>) {
  return <Select.Root data-slot="select-root" {...props} />;
}

export default SelectRoot;
