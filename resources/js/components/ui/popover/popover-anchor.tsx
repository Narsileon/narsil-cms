import { Anchor } from "@radix-ui/react-popover";

export type PopoverAnchorProps = React.ComponentProps<typeof Anchor> & {};

function PopoverAnchor({ ...props }: PopoverAnchorProps) {
  return <Anchor data-slot="popover-anchor" {...props} />;
}

export default PopoverAnchor;
