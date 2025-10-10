import { cn } from "@narsil-cms/lib/utils";
import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarContentProps = ComponentProps<typeof Menubar.Content>;

function MenubarContent({
  className,
  align = "start",
  alignOffset = -4,
  sideOffset = 8,
  ...props
}: MenubarContentProps) {
  return (
    <Menubar.Content
      data-slot="menubar-content"
      className={cn(
        "bg-popover text-popover-foreground z-50 min-w-[12rem] overflow-hidden rounded-md border p-1 shadow-md",
        "data-[state=open]:animate-in",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "origin-(--radix-menubar-content-transform-origin) will-change-transform",
        className,
      )}
      align={align}
      alignOffset={alignOffset}
      sideOffset={sideOffset}
      {...props}
    />
  );
}
export default MenubarContent;
