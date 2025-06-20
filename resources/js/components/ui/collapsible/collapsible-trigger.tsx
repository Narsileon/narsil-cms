import { CollapsibleTrigger as Trigger } from "@radix-ui/react-collapsible";

export type CollapsibleTriggerProps = React.ComponentProps<typeof Trigger> & {};

function CollapsibleTrigger({ ...props }: CollapsibleTriggerProps) {
  return <Trigger data-slot="collapsible-trigger" {...props} />;
}

export default CollapsibleTrigger;
