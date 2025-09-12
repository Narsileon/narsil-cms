import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import ScrollAreaScrollBar from "./scroll-area-scrollbar";

type ScrollAreaProps = React.ComponentProps<typeof ScrollAreaPrimitive.Root> & {
  orientation?: ComponentProps<typeof ScrollAreaScrollBar>["orientation"];
};

const ScrollArea = ({
  asChild = false,
  className,
  children,
  orientation = "vertical",
  ...props
}: ScrollAreaProps) => {
  return (
    <ScrollAreaPrimitive.Root
      data-slot="scroll-area"
      className={cn("relative overflow-hidden", className)}
      {...props}
    >
      <ScrollAreaPrimitive.Viewport
        data-slot="scroll-area-viewport"
        className={cn(
          "height-[inherit] size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
          "focus-visible:ring-2 focus-visible:ring-ring/50 focus-visible:outline-1",
          asChild && "!block",
        )}
        asChild={asChild}
      >
        {children}
      </ScrollAreaPrimitive.Viewport>
      <ScrollAreaScrollBar orientation={orientation} />
      <ScrollAreaPrimitive.Corner />
    </ScrollAreaPrimitive.Root>
  );
};

export default ScrollArea;
