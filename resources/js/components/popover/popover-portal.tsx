import { Popover } from "@base-ui/react/popover";

function PopoverPortal({ ...props }: Popover.Portal.Props) {
  return <Popover.Portal data-slot="popover-portal" {...props} />;
}

export default PopoverPortal;
