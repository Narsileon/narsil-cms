import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";
import { Icon } from "@narsil-cms/components/ui/icon";

type DropdownMenuSubTriggerProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.SubTrigger
> & {
  inset?: boolean;
};

function DropdownMenuSubTrigger({
  children,
  className,
  inset,
  ...props
}: DropdownMenuSubTriggerProps) {
  return (
    <DropdownMenuPrimitive.SubTrigger
      data-slot="dropdown-menu-sub-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-default items-center rounded-md px-2 py-1.5 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    >
      {children}
      <Icon className="ml-auto size-4" name="chevron-right" />
    </DropdownMenuPrimitive.SubTrigger>
  );
}

export default DropdownMenuSubTrigger;
