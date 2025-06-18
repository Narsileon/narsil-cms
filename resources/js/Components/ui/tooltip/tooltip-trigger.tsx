import { Trigger } from "@radix-ui/react-tooltip";

export type TooltipTriggerProps = React.ComponentProps<typeof Trigger> & {};

function TooltipTrigger({ ...props }: React.ComponentProps<typeof Trigger>) {
  return <Trigger data-slot="tooltip-trigger" {...props} />;
}

export default TooltipTrigger;
