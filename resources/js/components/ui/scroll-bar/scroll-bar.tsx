import { cn } from "@/components";
import {
  ScrollAreaScrollbar,
  ScrollAreaThumb,
} from "@radix-ui/react-scroll-area";

export type ScrollBarProp = React.ComponentProps<
  typeof ScrollAreaScrollbar
> & {};

const ScrollBar = ({
  className,
  orientation = "vertical",
  ...props
}: ScrollBarProp) => {
  return (
    <ScrollAreaScrollbar
      data-slot="scroll-area-scrollbar"
      className={cn(
        "flex touch-none p-px transition-colors select-none",
        orientation === "vertical" &&
          "h-full w-2.5 border-l border-l-transparent",
        orientation === "horizontal" &&
          "h-2.5 flex-col border-t border-t-transparent",
        className,
      )}
      orientation={orientation}
      {...props}
    >
      <ScrollAreaThumb
        data-slot="scroll-area-thumb"
        className="bg-border relative flex-1 rounded-full"
        {...props}
      />
    </ScrollAreaScrollbar>
  );
};

export default ScrollBar;
