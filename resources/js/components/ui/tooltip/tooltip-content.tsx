import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Tooltip as TooltipPrimitive } from "radix-ui";

type TooltipContentProps = React.ComponentProps<
  typeof TooltipPrimitive.Content
> & {};

function TooltipContent({
  children,
  className,
  sideOffset = 0,
  ...props
}: TooltipContentProps) {
  return (
    <TooltipPrimitive.Portal>
      <TooltipPrimitive.Content
        data-slot="tooltip-content"
        className={cn(
          "bg-primary text-primary-foreground animate-in fade-in-0 zoom-in-95 z-50 w-fit rounded-md border px-3 py-1.5 text-xs text-balance",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95",
          "origin-(--radix-tooltip-content-transform-origin) will-change-transform",
          className,
        )}
        sideOffset={sideOffset}
        {...props}
      >
        {children}
        <TooltipPrimitive.Arrow className="bg-primary fill-primary z-50 size-2.5 translate-y-[calc(-50%_-_2px)] rotate-45" />
      </TooltipPrimitive.Content>
    </TooltipPrimitive.Portal>
  );
}

export default TooltipContent;
