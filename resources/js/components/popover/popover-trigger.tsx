import { Popover } from "radix-ui";
import { type ComponentProps } from "react";

type PopoverTriggerProps = ComponentProps<typeof Popover.Trigger> & {};

function PopoverTrigger({ ...props }: PopoverTriggerProps) {
  return <Popover.Trigger data-slot="popover-trigger" {...props} />;
}

export default PopoverTrigger;
