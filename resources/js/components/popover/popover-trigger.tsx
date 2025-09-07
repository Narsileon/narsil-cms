import * as React from "react";
import { Popover as PopoverPrimitive } from "radix-ui";

type PopoverTriggerProps = React.ComponentProps<
  typeof PopoverPrimitive.Trigger
> & {};

function PopoverTrigger({ ...props }: PopoverTriggerProps) {
  return <PopoverPrimitive.Trigger data-slot="popover-trigger" {...props} />;
}

export default PopoverTrigger;
