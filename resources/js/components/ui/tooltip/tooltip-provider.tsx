import { Tooltip as TooltipPrimitive } from "radix-ui";

export type TooltipProviderProps = React.ComponentProps<
  typeof TooltipPrimitive.Provider
> & {};

function TooltipProvider({
  delayDuration = 0,
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
