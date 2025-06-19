import { cn } from "@/Components";
import { Content, Portal } from "@radix-ui/react-hover-card";

export type HoverCardContentProps = React.ComponentProps<typeof Content> & {};

function HoverCardContent({
  align = "center",
  className,
  sideOffset = 4,
  ...props
}: HoverCardContentProps) {
  return (
    <Portal data-slot="hover-card-portal">
      <Content
        data-slot="hover-card-content"
        className={cn(
          "bg-popover text-popover-foreground z-50 w-64 rounded-md border p-4 shadow-md outline-hidden",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=open]:zoom-in-95 data-[state=closed]:zoom-out-95",
          "origin-(--radix-hover-card-content-transform-origin)",
          className,
        )}
        align={align}
        sideOffset={sideOffset}
        {...props}
      />
    </Portal>
  );
}

export default HoverCardContent;
