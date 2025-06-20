import { Group } from "@radix-ui/react-select";

export type SelectGroupProps = React.ComponentProps<typeof Group> & {};

function SelectGroup({ ...props }: SelectGroupProps) {
  return <Group data-slot="select-group" {...props} />;
}

export default SelectGroup;
