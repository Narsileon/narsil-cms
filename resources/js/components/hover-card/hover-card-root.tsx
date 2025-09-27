import { HoverCard } from "radix-ui";
import { type ComponentProps } from "react";

type HoverCardRootProps = ComponentProps<typeof HoverCard.Root> & {};

function HoverCardRoot({ ...props }: HoverCardRootProps) {
  return <HoverCard.Root data-slot="hover-card-root" {...props} />;
}

export default HoverCardRoot;
