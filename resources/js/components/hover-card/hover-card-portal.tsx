import { HoverCard as HoverCardPrimitive } from "radix-ui";

type HoverCardPortalProps = React.ComponentProps<
  typeof HoverCardPrimitive.Portal
> & {};

function HoverCardPortal({ ...props }: HoverCardPortalProps) {
  return <HoverCardPrimitive.Portal data-slot="hover-card-portal" {...props} />;
}

export default HoverCardPortal;
