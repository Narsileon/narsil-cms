import { Popover } from "radix-ui";
import { type ComponentProps } from "react";

type PopoverPortalProps = ComponentProps<typeof Popover.Portal>;

function PopoverPortal({ ...props }: PopoverPortalProps) {
  return <Popover.Portal data-slot="popover-portal" {...props} />;
}

export default PopoverPortal;
