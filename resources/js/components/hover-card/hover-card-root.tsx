import { HoverCard as HoverCardPrimitive } from "radix-ui";

type HoverCardRootProps = React.ComponentProps<
  typeof HoverCardPrimitive.Root
> & {};

function HoverCardRoot({ ...props }: HoverCardRootProps) {
  return <HoverCardPrimitive.Root data-slot="hover-card-root" {...props} />;
}

export default HoverCardRoot;
