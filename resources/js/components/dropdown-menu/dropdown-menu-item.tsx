import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuItemProps = Menu.Item.Props & {
  inset?: boolean;
  variant?: "default" | "destructive";
};

function DropdownMenuItem({
  className,
  inset,
  variant = "default",
  ...props
}: DropdownMenuItemProps) {
  return (
    <Menu.Item
      data-slot="dropdown-menu-item"
      data-inset={inset}
      data-variant={variant}
      className={cn(
        "group/menu-item",
        "relative flex min-h-9 w-full cursor-default items-center justify-start gap-1.5 rounded-md px-1.5 py-1 text-sm outline-hidden select-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0",
        "dark:data-[variant=destructive]:focus:bg-destructive/20",
        "data-[variant=destructive]:*:[svg]:text-destructive",
        "data-[variant=destructive]:focus:bg-destructive/10 data-[variant=destructive]:focus:text-destructive",
        "data-[variant=destructive]:text-destructive",
        "data-disabled:pointer-events-none data-disabled:opacity-50",
        "data-inset:pl-8",
        "focus:bg-accent focus:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuItem;
