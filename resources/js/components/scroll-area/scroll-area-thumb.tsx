import { ScrollArea } from "@base-ui/react/scroll-area";
import { cn } from "@narsil-cms/lib/utils";

function ScrollAreaThumb({ className, ...props }: ScrollArea.Thumb.Props) {
  return (
    <ScrollArea.Thumb
      data-slot="scroll-area-thumb"
      className={cn("relative flex-1 rounded-full bg-border", className)}
      {...props}
    />
  );
}

export default ScrollAreaThumb;
