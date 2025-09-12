import { cn } from "@narsil-cms/lib/utils";
import { HoverCard as HoverCardPrimitive } from "radix-ui";

type HoverCardContentProps = React.ComponentProps<
  typeof HoverCardPrimitive.Content
> & {};

function HoverCardContent({
  align = "center",
  className,
  sideOffset = 4,
  ...props
}: HoverCardContentProps) {
  return (
    <HoverCardPrimitive.Portal data-slot="hover-card-portal">
      <HoverCardPrimitive.Content
        data-slot="hover-card-content"
        className={cn(
          "z-50 w-64 rounded-md border bg-popover p-4 text-popover-foreground shadow-md outline-hidden",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=open]:zoom-in-95 data-[state=closed]:zoom-out-95",
          "origin-(--radix-hover-card-content-transform-origin) will-change-transform",
          className,
        )}
        align={align}
        sideOffset={sideOffset}
        {...props}
      />
    </HoverCardPrimitive.Portal>
  );
}

export default HoverCardContent;
