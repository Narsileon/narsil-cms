import { Tooltip as TooltipPrimitive } from "radix-ui";

import TooltipProvider from "./tooltip-provider";

function TooltipRoot({
  ...props
}: React.ComponentProps<typeof TooltipPrimitive.Root>) {
  return (
    <TooltipProvider>
      <TooltipPrimitive.Root data-slot="tooltip-root" {...props} />
    </TooltipProvider>
  );
}

export default TooltipRoot;
