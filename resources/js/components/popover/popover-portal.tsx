import { Popover } from "radix-ui";

type PopoverPortalProps = React.ComponentProps<typeof Popover.Portal> & {};

function PopoverPortal({ ...props }: PopoverPortalProps) {
  return <Popover.Portal data-slot="popover-portal" {...props} />;
}

export default PopoverPortal;
