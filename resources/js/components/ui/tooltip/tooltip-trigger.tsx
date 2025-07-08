import { Tooltip as TooltipPrimitive } from "radix-ui";

type TooltipTriggerProps = React.ComponentProps<
  typeof TooltipPrimitive.Trigger
> & {};

function TooltipTrigger({ ...props }: TooltipTriggerProps) {
  return <TooltipPrimitive.Trigger data-slot="tooltip-trigger" {...props} />;
}

export default TooltipTrigger;
