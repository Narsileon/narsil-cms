import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipProviderProps = ComponentProps<typeof Tooltip.Provider>;

function TooltipProvider({ ...props }: TooltipProviderProps) {
  return <Tooltip.Provider data-slot="tooltip-provider" {...props} />;
}

export default TooltipProvider;
