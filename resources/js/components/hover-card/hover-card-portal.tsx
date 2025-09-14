import { HoverCard } from "radix-ui";

type HoverCardPortalProps = React.ComponentProps<typeof HoverCard.Portal> & {};

function HoverCardPortal({ ...props }: HoverCardPortalProps) {
  return <HoverCard.Portal data-slot="hover-card-portal" {...props} />;
}

export default HoverCardPortal;
