import { Tooltip } from "@base-ui/react/tooltip";

function TooltipPortal({ ...props }: Tooltip.Portal.Props) {
  return <Tooltip.Portal data-slot="tooltip-portal" {...props} />;
}

export default TooltipPortal;
