import { Select } from "radix-ui";

type SelectGroupProps = React.ComponentProps<typeof Select.Group> & {};

function SelectGroup({ ...props }: SelectGroupProps) {
  return <Select.Group data-slot="select-group" {...props} />;
}

export default SelectGroup;
