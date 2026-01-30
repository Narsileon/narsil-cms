import { Tooltip } from "@base-ui/react/tooltip";

function TooltipRoot({ ...props }: Tooltip.Root.Props) {
  return <Tooltip.Root data-slot="tooltip-root" {...props} />;
}

export default TooltipRoot;
