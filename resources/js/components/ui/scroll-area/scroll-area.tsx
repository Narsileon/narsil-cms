import { cn } from "@/components";
import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";
import ScrollAreaScrollBar from "./scroll-area-scrollbar";

export type ScrollAreaProps = React.ComponentProps<
  typeof ScrollAreaPrimitive.Root
> & {};

const ScrollArea = ({ className, children, ...props }: ScrollAreaProps) => {
  return (
    <ScrollAreaPrimitive.Root
      data-slot="scroll-area"
      className={cn("relative overflow-hidden", className)}
      {...props}
    >
      <ScrollAreaPrimitive.Viewport
        data-slot="scroll-area-viewport"
        className={cn(
          "size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
          "focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-1",
        )}
      >
        {children}
      </ScrollAreaPrimitive.Viewport>
      <ScrollAreaScrollBar />
      <ScrollAreaPrimitive.Corner />
    </ScrollAreaPrimitive.Root>
  );
};

export default ScrollArea;
