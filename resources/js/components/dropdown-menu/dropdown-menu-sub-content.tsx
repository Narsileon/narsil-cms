import { cn } from "@narsil-cms/lib/utils";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuSubContentProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.SubContent
> & {};

function DropdownMenuSubContent({
  className,
  ...props
}: DropdownMenuSubContentProps) {
  return (
    <DropdownMenuPrimitive.SubContent
      data-slot="dropdown-menu-sub-content"
      className={cn(
        "text-popover-foregroundoverflow-hidden z-50 min-w-[8rem] rounded-md border bg-popover p-1 shadow-lg",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "origin-(--radix-dropdown-menu-content-transform-origin) will-change-transform",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuSubContent;
