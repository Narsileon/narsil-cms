import { cn } from "@narsil-cms/lib/utils";
import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

type ScrollAreaScrollbarProp = ComponentProps<typeof ScrollArea.ScrollAreaScrollbar>;

const ScrollAreaScrollBar = ({
  className,
  orientation = "vertical",
  ...props
}: ScrollAreaScrollbarProp) => {
  return (
    <ScrollArea.ScrollAreaScrollbar
      data-slot="scroll-area-scrollbar"
      className={cn(
        "flex touch-none select-none p-px transition-colors",
        orientation === "vertical" && "h-full w-2.5 border-l border-l-transparent",
        orientation === "horizontal" && "h-2.5 flex-col border-t border-t-transparent",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
};

export default ScrollAreaScrollBar;
