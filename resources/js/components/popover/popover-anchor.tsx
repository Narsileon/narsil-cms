import { Popover } from "radix-ui";

type PopoverAnchorProps = React.ComponentProps<typeof Popover.Anchor> & {};

function PopoverAnchor({ ...props }: PopoverAnchorProps) {
  return <Popover.Anchor data-slot="popover-anchor" {...props} />;
}

export default PopoverAnchor;
