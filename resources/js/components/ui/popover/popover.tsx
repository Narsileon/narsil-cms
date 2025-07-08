import { Popover as PopoverPrimitive } from "radix-ui";

type PopoverProps = React.ComponentProps<typeof PopoverPrimitive.Root> & {};

function Popover({ ...props }: PopoverProps) {
  return <PopoverPrimitive.Root data-slot="popover" {...props} />;
}

export default Popover;
