import * as React from "react";
import { Select as SelectPrimitive } from "radix-ui";

type SelectGroupProps = React.ComponentProps<typeof SelectPrimitive.Group> & {};

function SelectGroup({ ...props }: SelectGroupProps) {
  return <SelectPrimitive.Group data-slot="select-group" {...props} />;
}

export default SelectGroup;
