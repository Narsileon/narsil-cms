import { Tooltip } from "radix-ui";

type TooltipTriggerProps = React.ComponentProps<typeof Tooltip.Trigger> & {};

function TooltipTrigger({ asChild = true, ...props }: TooltipTriggerProps) {
  return (
    <Tooltip.Trigger data-slot="tooltip-trigger" asChild={asChild} {...props} />
  );
}

export default TooltipTrigger;
