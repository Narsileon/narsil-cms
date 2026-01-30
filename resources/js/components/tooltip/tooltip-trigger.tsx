import { Tooltip } from "@base-ui/react/tooltip";

function TooltipTrigger({ ...props }: Tooltip.Trigger.Props) {
  return <Tooltip.Trigger data-slot="tooltip-trigger" {...props} />;
}

export default TooltipTrigger;
