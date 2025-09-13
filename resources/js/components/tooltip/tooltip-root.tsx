import { Tooltip } from "radix-ui";

type TooltipProviderProps = React.ComponentProps<typeof Tooltip.Root> & {};

function TooltipRoot({ ...props }: TooltipProviderProps) {
  return <Tooltip.Root data-slot="tooltip-root" {...props} />;
}

export default TooltipRoot;
