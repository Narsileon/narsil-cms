import { Tooltip as TooltipPrimitive } from "radix-ui";

type TooltipProviderProps = React.ComponentProps<
  typeof TooltipPrimitive.Provider
> & {};

function TooltipProvider({
  delayDuration = 300,
  ...props
}: TooltipProviderProps) {
  return (
    <TooltipPrimitive.Provider
      data-slot="tooltip-provider"
      delayDuration={delayDuration}
      {...props}
    />
  );
}

export default TooltipProvider;
