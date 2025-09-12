import { cn } from "@narsil-cms/lib/utils";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarSubContentProps = React.ComponentProps<
  typeof MenubarPrimitive.SubContent
> & {};

function MenubarSubContent({ className, ...props }: MenubarSubContentProps) {
  return (
    <MenubarPrimitive.SubContent
      data-slot="menubar-sub-content"
      className={cn(
        "z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-lg",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "origin-(--radix-menubar-content-transform-origin) will-change-transform",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarSubContent;
