import { cn } from "@narsil-cms/lib/utils";
import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuSubContentProps = ComponentProps<typeof DropdownMenu.SubContent>;

function DropdownMenuSubContent({ className, ...props }: DropdownMenuSubContentProps) {
  return (
    <DropdownMenu.SubContent
      data-slot="dropdown-menu-sub-content"
      className={cn(
        "text-popover-foregroundoverflow-hidden z-50 min-w-32 rounded-md border bg-popover p-1 shadow-lg",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
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
