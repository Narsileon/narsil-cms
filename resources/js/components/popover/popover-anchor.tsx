import { Popover as PopoverPrimitive } from "radix-ui";

type PopoverAnchorProps = React.ComponentProps<
  typeof PopoverPrimitive.Anchor
> & {};

function PopoverAnchor({ ...props }: PopoverAnchorProps) {
  return <PopoverPrimitive.Anchor data-slot="popover-anchor" {...props} />;
}

export default PopoverAnchor;
