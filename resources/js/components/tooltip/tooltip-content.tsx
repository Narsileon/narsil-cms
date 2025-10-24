import { cn } from "@narsil-cms/lib/utils";
import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipContentProps = ComponentProps<typeof Tooltip.Content>;

function TooltipContent({ className, sideOffset = 0, ...props }: TooltipContentProps) {
  return (
    <Tooltip.Content
      data-slot="tooltip-content"
      className={cn(
        "z-50 w-fit animate-in rounded-md border bg-primary px-3 py-1.5 text-xs text-balance text-primary-foreground fade-in-0 zoom-in-95",
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
    />
  );
}

export default TooltipContent;
