import { Popover } from "radix-ui";

type PopoverProps = React.ComponentProps<typeof Popover.Root> & {};

function PopoverRoot({ ...props }: PopoverProps) {
  return <Popover.Root data-slot="popover-root" {...props} />;
}

export default PopoverRoot;
