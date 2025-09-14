import { HoverCard } from "radix-ui";

type HoverCardTriggerProps = React.ComponentProps<
  typeof HoverCard.Trigger
> & {};

function HoverCardTrigger({ ...props }: HoverCardTriggerProps) {
  return <HoverCard.Trigger data-slot="hover-card-trigger" {...props} />;
}

export default HoverCardTrigger;
