import { Tooltip as TooltipPrimitive } from "radix-ui";

type TooltipProviderProps = React.ComponentProps<
  typeof TooltipPrimitive.Provider
> & {};

function TooltipProvider({ ...props }: TooltipProviderProps) {
  return <TooltipPrimitive.Provider data-slot="tooltip-provider" {...props} />;
}

export default TooltipProvider;
