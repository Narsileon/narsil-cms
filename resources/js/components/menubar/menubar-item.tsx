import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type MenubarItemProps = ComponentProps<typeof Menubar.Item> & {
  inset?: boolean;
  variant?: "default" | "destructive";
};

function MenubarItem({
  className,
  inset,
  variant = "default",
  ...props
}: MenubarItemProps) {
  return (
    <Menubar.Item
      data-slot="menubar-item"
      data-inset={inset}
      data-variant={variant}
      className={cn(
        "outline-hidden relative flex cursor-pointer select-none items-center gap-2 rounded-md px-2 py-1.5",
        "focus:bg-accent focus:text-accent-foreground",
        "dark:data-[variant=destructive]:focus:bg-destructive/20",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "data-[inset]:pl-8",
        "data-[variant=destructive]:*:[svg]:!text-destructive",
        "data-[variant=destructive]:focus:bg-destructive/10 data-[variant=destructive]:focus:text-destructive",
        "data-[variant=destructive]:text-destructive",
        "[&_svg:not([class*='text-'])]:text-muted-foreground [&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarItem;
