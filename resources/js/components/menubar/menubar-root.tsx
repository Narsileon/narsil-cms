import { cn } from "@narsil-cms/lib/utils";
import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarRootProps = ComponentProps<typeof Menubar.Root>;

function MenubarRoot({ className, ...props }: MenubarRootProps) {
  return (
    <Menubar.Root
      data-slot="menubar-root"
      className={cn(
        "flex h-9 items-center gap-1 rounded-md border bg-background p-1 shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarRoot;
