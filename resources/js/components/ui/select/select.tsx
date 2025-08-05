import * as React from "react";
import { Select as SelectPrimitive } from "radix-ui";

type SelectProps = React.ComponentProps<typeof SelectPrimitive.Root> & {};

function Select({ ...props }: SelectProps) {
  return <SelectPrimitive.Root data-slot="select" {...props} />;
}

export default Select;
