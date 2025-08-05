import * as React from "react";
import { Select as SelectPrimitive } from "radix-ui";

type SelectValueProps = React.ComponentProps<typeof SelectPrimitive.Value> & {};

function SelectValue({ ...props }: SelectValueProps) {
  return <SelectPrimitive.Value data-slot="select-value" {...props} />;
}

export default SelectValue;
