import { ScrollArea } from "@base-ui/react/scroll-area";
import { cn } from "@narsil-cms/lib/utils";

function ScrollAreaViewport({ className, ...props }: ScrollArea.Viewport.Props) {
  return (
    <ScrollArea.Viewport
      data-slot="scroll-area-viewport"
      className={cn(
        "size-full rounded-[inherit] transition-[color,box-shadow] outline-none focus-visible:ring-[3px]",
        "focus-visible:ring-ring/50 focus-visible:outline-1",
        className,
      )}
      {...props}
    />
  );
}

export default ScrollAreaViewport;
