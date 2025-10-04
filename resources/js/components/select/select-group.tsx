import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectGroupProps = ComponentProps<typeof Select.Group>;

function SelectGroup({ ...props }: SelectGroupProps) {
  return <Select.Group data-slot="select-group" {...props} />;
}

export default SelectGroup;
