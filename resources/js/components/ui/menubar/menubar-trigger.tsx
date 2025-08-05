import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarTriggerProps = React.ComponentProps<
  typeof MenubarPrimitive.Trigger
> & {};

function MenubarTrigger({ className, ...props }: MenubarTriggerProps) {
  return (
    <MenubarPrimitive.Trigger
      data-slot="menubar-trigger"
      className={cn(
        "flex items-center rounded-md px-2 py-1 text-sm font-medium outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarTrigger;
