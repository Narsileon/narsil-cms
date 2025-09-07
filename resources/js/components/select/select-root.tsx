import * as React from "react";
import { Select as SelectPrimitive } from "radix-ui";

type SelectRootProps = React.ComponentProps<typeof SelectPrimitive.Root> & {};

function SelectRoot({ ...props }: SelectRootProps) {
  return <SelectPrimitive.Root data-slot="select-root" {...props} />;
}

export default SelectRoot;
