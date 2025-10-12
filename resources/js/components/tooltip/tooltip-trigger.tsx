import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipTriggerProps = ComponentProps<typeof Tooltip.Trigger>;

function TooltipTrigger({ asChild = true, ...props }: TooltipTriggerProps) {
  return <Tooltip.Trigger data-slot="tooltip-trigger" asChild={asChild} {...props} />;
}

export default TooltipTrigger;
