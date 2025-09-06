import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Popover as PopoverPrimitive } from "radix-ui";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";

type PopoverContentProps = React.ComponentProps<
  typeof PopoverPrimitive.Content
> & {};

function PopoverContent({
  children,
  className,
  align = "center",
  sideOffset = 4,
  ...props
}: PopoverContentProps) {
  return (
    <PopoverPrimitive.Portal>
      <PopoverPrimitive.Content
        data-slot="popover-content"
        align={align}
        sideOffset={sideOffset}
        className={cn(
          "bg-popover text-popover-foreground z-50 w-72 rounded-xl border p-4 shadow-md outline-hidden",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "origin-(--radix-popover-content-transform-origin) will-change-transform",
          className,
        )}
        {...props}
      >
        <VisuallyHidden aria-hidden="true" tabIndex={0}>
          Popover
        </VisuallyHidden>
        {children}
      </PopoverPrimitive.Content>
    </PopoverPrimitive.Portal>
  );
}

export default PopoverContent;
