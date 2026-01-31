import { ScrollArea } from "@base-ui/react/scroll-area";
import { cn } from "@narsil-cms/lib/utils";

function ScrollAreaRoot({ className, ...props }: ScrollArea.Root.Props) {
  return (
    <ScrollArea.Root
      data-slot="scroll-area-root"
      className={cn("relative", className)}
      {...props}
    />
  );
}

export default ScrollAreaRoot;
