import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarRootProps = React.ComponentProps<typeof MenubarPrimitive.Root> & {};

function MenubarRoot({ className, ...props }: MenubarRootProps) {
  return (
    <MenubarPrimitive.Root
      data-slot="menubar-root"
      className={cn(
        "bg-background flex h-9 items-center gap-1 rounded-md border p-1 shadow-xs",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarRoot;
