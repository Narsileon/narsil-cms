import { Trigger } from "@radix-ui/react-tooltip";

export type TooltipTriggerProps = React.ComponentProps<typeof Trigger> & {};

function TooltipTrigger({ ...props }: TooltipTriggerProps) {
  return <Trigger data-slot="tooltip-trigger" {...props} />;
}

export default TooltipTrigger;
