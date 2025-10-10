import { cn } from "@narsil-cms/lib/utils";
import { HoverCard } from "radix-ui";
import { type ComponentProps } from "react";

type HoverCardContentProps = ComponentProps<typeof HoverCard.Content>;

function HoverCardContent({
  align = "center",
  className,
  sideOffset = 4,
  ...props
}: HoverCardContentProps) {
  return (
    <HoverCard.Content
      data-slot="hover-card-content"
      className={cn(
        "bg-popover text-popover-foreground outline-hidden z-50 w-64 rounded-md border p-4 shadow-md",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "origin-(--radix-hover-card-content-transform-origin) will-change-transform",
        className,
      )}
      align={align}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default HoverCardContent;
