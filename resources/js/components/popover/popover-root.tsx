import { Popover } from "radix-ui";
import { type ComponentProps } from "react";

type PopoverProps = ComponentProps<typeof Popover.Root>;

function PopoverRoot({ ...props }: PopoverProps) {
  return <Popover.Root data-slot="popover-root" {...props} />;
}

export default PopoverRoot;
