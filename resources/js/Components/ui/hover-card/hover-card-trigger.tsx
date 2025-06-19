import { Trigger } from "@radix-ui/react-hover-card";

export type HoverCardTriggerProps = React.ComponentProps<typeof Trigger> & {};

function HoverCardTrigger({ ...props }: HoverCardTriggerProps) {
  return <Trigger data-slot="hover-card-trigger" {...props} />;
}

export default HoverCardTrigger;
