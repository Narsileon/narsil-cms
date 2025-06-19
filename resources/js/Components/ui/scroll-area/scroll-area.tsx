import { cn } from "@/Components";
import { Corner, Root, Viewport } from "@radix-ui/react-scroll-area";
import { ScrollBar } from "@/Components/ui/scroll-bar";

export type ScrollAreaProps = React.ComponentProps<typeof Root> & {};

const ScrollArea = ({ className, children, ...props }: ScrollAreaProps) => {
  return (
    <Root
      data-slot="scroll-area"
      className={cn("relative overflow-hidden", className)}
      {...props}
    >
      <Viewport
        data-slot="scroll-area-viewport"
        className={cn(
          "size-full rounded-[inherit] transition-[color,box-shadow] outline-none",
          "focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-1",
        )}
      >
        {children}
      </Viewport>
      <ScrollBar />
      <Corner />
    </Root>
  );
};

export default ScrollArea;
