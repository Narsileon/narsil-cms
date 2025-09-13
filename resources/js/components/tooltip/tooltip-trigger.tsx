import { Tooltip } from "radix-ui";

type TooltipTriggerProps = React.ComponentProps<typeof Tooltip.Trigger> & {};

function TooltipTrigger({ ...props }: TooltipTriggerProps) {
  return <Tooltip.Trigger data-slot="tooltip-trigger" {...props} />;
}

export default TooltipTrigger;
