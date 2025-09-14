import { Popover } from "radix-ui";

type PopoverProps = React.ComponentProps<typeof Popover.Root> & {};

function Popover({ ...props }: PopoverProps) {
  return <Popover.Root data-slot="popover-root" {...props} />;
}

export default Popover;
