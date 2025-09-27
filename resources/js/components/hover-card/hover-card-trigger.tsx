import { HoverCard } from "radix-ui";
import { type ComponentProps } from "react";

type HoverCardTriggerProps = ComponentProps<typeof HoverCard.Trigger> & {};

function HoverCardTrigger({ ...props }: HoverCardTriggerProps) {
  return <HoverCard.Trigger data-slot="hover-card-trigger" {...props} />;
}

export default HoverCardTrigger;
