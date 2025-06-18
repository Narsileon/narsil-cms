import { cn } from "@/Components";
import { Corner, Root, Viewport } from "@radix-ui/react-scroll-area";
import { ScrollBar } from "@/Components/ui/scroll-bar";

export type ScrollAreaProps = React.ComponentProps<typeof Root> & {};

const ScrollArea = ({ className, children, ...props }: ScrollAreaProps) => {
  return (
    <Root
      className={cn("relative overflow-hidden", className)}
      data-slot="scroll-area"
      {...props}
    >
      <Viewport
        className={cn(
          "size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
          "focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-1",
        )}
        data-slot="scroll-area-viewport"
      >
        {children}
      </Viewport>
      <ScrollBar />
      <Corner />
    </Root>
  );
};

export default ScrollArea;
