import { ScrollArea } from "@base-ui/react/scroll-area";
import { cn } from "@narsil-cms/lib/utils";

function ScrollAreaScrollBar({
  className,
  orientation = "vertical",
  ...props
}: ScrollArea.Scrollbar.Props) {
  return (
    <ScrollArea.Scrollbar
      data-slot="scroll-area-scrollbar"
      data-orientation={orientation}
      className={cn(
        "flex touch-none p-px transition-colors select-none",
        "data-horizontal:h-2.5 data-horizontal:flex-col data-horizontal:border-t data-horizontal:border-t-transparent",
        "data-vertical:h-full data-vertical:w-2.5 data-vertical:border-l data-vertical:border-l-transparent",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
}

export default ScrollAreaScrollBar;
