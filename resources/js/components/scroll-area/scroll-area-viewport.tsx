import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaViewportProps = ComponentProps<typeof ScrollArea.Viewport> & {
  orientation?: ComponentProps<typeof ScrollArea.Viewport>;
};

const ScrollAreaViewport = ({
  asChild = false,
  className,
  ...props
}: ScrollAreaViewportProps) => {
  return (
    <ScrollArea.Viewport
      data-slot="scroll-area-viewport"
      className={cn(
        "size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
        "focus-visible:ring-2 focus-visible:ring-ring/50 focus-visible:outline-1",
        asChild && "!block",
        className,
      )}
      asChild={asChild}
      {...props}
    />
  );
};

export default ScrollAreaViewport;
