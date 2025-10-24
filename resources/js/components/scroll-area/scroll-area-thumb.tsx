import { cn } from "@narsil-cms/lib/utils";
import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

type ScrollAreaThumbProps = ComponentProps<typeof ScrollArea.ScrollAreaThumb>;

const ScrollAreaThumb = ({ className, ...props }: ScrollAreaThumbProps) => {
  return (
    <ScrollArea.ScrollAreaThumb
      data-slot="scroll-area-thumb"
      className={cn("relative flex-1 rounded-full bg-border", className)}
      {...props}
    />
  );
};

export default ScrollAreaThumb;
