import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaViewportProps = React.ComponentProps<
  typeof ScrollAreaPrimitive.Viewport
> & {
  orientation?: React.ComponentProps<typeof ScrollAreaPrimitive.Viewport>;
};

const ScrollAreaViewport = ({
  asChild = false,
  className,
  ...props
}: ScrollAreaViewportProps) => {
  return (
    <ScrollAreaPrimitive.Viewport
      data-slot="scroll-area-viewport"
      className={cn(
        "height-[inherit] size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
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
