import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipPortalProps = ComponentProps<typeof Tooltip.Portal> & {};

function TooltipPortal({ ...props }: TooltipPortalProps) {
  return <Tooltip.Portal data-slot="tooltip-portal" {...props} />;
}

export default TooltipPortal;
