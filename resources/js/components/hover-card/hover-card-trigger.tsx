import { HoverCard as HoverCardPrimitive } from "radix-ui";

type HoverCardTriggerProps = React.ComponentProps<
  typeof HoverCardPrimitive.Trigger
> & {};

function HoverCardTrigger({ ...props }: HoverCardTriggerProps) {
  return (
    <HoverCardPrimitive.Trigger data-slot="hover-card-trigger" {...props} />
  );
}

export default HoverCardTrigger;
