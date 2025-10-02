import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuContentProps = ComponentProps<
  typeof DropdownMenu.Content
> & {};

function DropdownMenuContent({
  className,
  sideOffset = 4,
  ...props
}: DropdownMenuContentProps) {
  return (
    <DropdownMenu.Portal>
      <DropdownMenu.Content
        data-slot="dropdown-menu-content"
        className={cn(
          "bg-popover text-popover-foreground min-w-[8rem] overflow-y-auto overflow-x-hidden rounded-xl border p-1 shadow-md",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2 z-50",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=closed]:animate-out data-[state=open]:animate-in",
          "max-h-(--radix-dropdown-menu-content-available-height)",
          "origin-(--radix-dropdown-menu-content-transform-origin) will-change-transform",
          className,
        )}
        sideOffset={sideOffset}
        {...props}
      />
    </DropdownMenu.Portal>
  );
}

export default DropdownMenuContent;
