import { HoverCard } from "radix-ui";
import { type ComponentProps } from "react";

type HoverCardPortalProps = ComponentProps<typeof HoverCard.Portal>;

function HoverCardPortal({ ...props }: HoverCardPortalProps) {
  return <HoverCard.Portal data-slot="hover-card-portal" {...props} />;
}

export default HoverCardPortal;
