import { Menubar as MenubarPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type MenubarRootProps = React.ComponentProps<typeof MenubarPrimitive.Root> & {};

function MenubarRoot({ className, ...props }: MenubarRootProps) {
  return (
    <MenubarPrimitive.Root
      data-slot="menubar-root"
      className={cn(
        "flex h-9 items-center gap-1 rounded-md border bg-background p-1 shadow-xs",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarRoot;
