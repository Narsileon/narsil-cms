import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaThumbProps = ComponentProps<
  typeof ScrollArea.ScrollAreaThumb
> & {};

const ScrollAreaThumb = ({ className, ...props }: ScrollAreaThumbProps) => {
  return (
    <ScrollArea.ScrollAreaThumb
      data-slot="scroll-area-thumb"
      className={cn("bg-border relative flex-1 rounded-full", className)}
      {...props}
    />
  );
};

export default ScrollAreaThumb;
