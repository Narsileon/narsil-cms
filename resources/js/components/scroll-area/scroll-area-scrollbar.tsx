import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaScrollbarProp = React.ComponentProps<
  typeof ScrollAreaPrimitive.ScrollAreaScrollbar
> & {};

const ScrollAreaScrollBar = ({
  className,
  orientation = "vertical",
  ...props
}: ScrollAreaScrollbarProp) => {
  return (
    <ScrollAreaPrimitive.ScrollAreaScrollbar
      data-slot="scroll-area-scrollbar"
      className={cn(
        "flex touch-none p-px transition-colors select-none",
        orientation === "vertical" &&
          "h-full w-2.5 border-l border-l-transparent",
        orientation === "horizontal" &&
          "h-2.5 flex-col border-t border-t-transparent",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
};

export default ScrollAreaScrollBar;
