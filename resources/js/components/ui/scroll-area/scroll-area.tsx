import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";
import ScrollAreaScrollBar from "./scroll-area-scrollbar";

type ScrollAreaProps = React.ComponentProps<typeof ScrollAreaPrimitive.Root> & {
  orientation?: React.ComponentProps<typeof ScrollAreaScrollBar>["orientation"];
};

const ScrollArea = ({
  asChild = false,
  className,
  children,
  orientation = "vertical",
  ...props
}: ScrollAreaProps) => {
  return (
    <ScrollAreaPrimitive.Root
      data-slot="scroll-area"
      className={cn("relative overflow-hidden", className)}
      {...props}
    >
      <ScrollAreaPrimitive.Viewport
        data-slot="scroll-area-viewport"
        className={cn(
          "height-[inherit] size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
          "focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-1",
          asChild && "!block",
        )}
        asChild={asChild}
      >
        {children}
      </ScrollAreaPrimitive.Viewport>
      <ScrollAreaScrollBar orientation={orientation} />
      <ScrollAreaPrimitive.Corner />
    </ScrollAreaPrimitive.Root>
  );
};

export default ScrollArea;
