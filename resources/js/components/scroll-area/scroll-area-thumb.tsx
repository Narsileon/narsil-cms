import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaThumbProps = React.ComponentProps<
  typeof ScrollAreaPrimitive.ScrollAreaThumb
> & {};

const ScrollAreaThumb = ({ className, ...props }: ScrollAreaThumbProps) => {
  return (
    <ScrollAreaPrimitive.ScrollAreaThumb
      data-slot="scroll-area-thumb"
      className={cn("relative flex-1 rounded-full bg-border", className)}
      {...props}
    />
  );
};

export default ScrollAreaThumb;
