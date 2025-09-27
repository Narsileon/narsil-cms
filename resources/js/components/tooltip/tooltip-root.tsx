import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipProviderProps = ComponentProps<typeof Tooltip.Root> & {};

function TooltipRoot({ ...props }: TooltipProviderProps) {
  return <Tooltip.Root data-slot="tooltip-root" {...props} />;
}

export default TooltipRoot;
