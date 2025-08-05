import * as React from "react";
import { Tooltip as TooltipPrimitive } from "radix-ui";
import TooltipContent from "./tooltip-content";
import TooltipProvider from "./tooltip-provider";
import TooltipTrigger from "./tooltip-trigger";

type TooltipProps = React.ComponentProps<typeof TooltipPrimitive.Content> & {
  asChild?: boolean;
  tooltip: string | React.ReactNode;
};

function Tooltip({
  asChild = true,
  children,
  tooltip,
  ...props
}: TooltipProps) {
  return (
    <TooltipProvider>
      <TooltipPrimitive.Root data-slot="tooltip" {...props}>
        <TooltipTrigger asChild={asChild}>{children}</TooltipTrigger>
        <TooltipContent {...props}>{tooltip}</TooltipContent>
      </TooltipPrimitive.Root>
    </TooltipProvider>
  );
}

export default Tooltip;
