import { Tooltip } from "radix-ui";

type TooltipProviderProps = React.ComponentProps<typeof Tooltip.Provider> & {};

function TooltipProvider({ ...props }: TooltipProviderProps) {
  return <Tooltip.Provider data-slot="tooltip-provider" {...props} />;
}

export default TooltipProvider;
