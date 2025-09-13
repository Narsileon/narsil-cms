import { Tooltip } from "radix-ui";

type TooltipPortalProps = React.ComponentProps<typeof Tooltip.Portal> & {};

function TooltipPortal({ ...props }: TooltipPortalProps) {
  return <Tooltip.Portal data-slot="tooltip-portal" {...props} />;
}

export default TooltipPortal;
