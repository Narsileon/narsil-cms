import { Select } from "@base-ui/react/select";

function SelectList({ ...props }: Select.List.Props) {
  return <Select.List data-slot="select-list" {...props} />;
}

export default SelectList;
