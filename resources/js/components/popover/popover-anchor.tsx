import { Popover } from "radix-ui";
import { type ComponentProps } from "react";

type PopoverAnchorProps = ComponentProps<typeof Popover.Anchor>;

function PopoverAnchor({ ...props }: PopoverAnchorProps) {
  return <Popover.Anchor data-slot="popover-anchor" {...props} />;
}

export default PopoverAnchor;
