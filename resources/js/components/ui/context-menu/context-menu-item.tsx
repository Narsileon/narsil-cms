import { cn } from "@/lib/utils";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuItemProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Item
> & {
  inset?: boolean;
  variant?: "default" | "destructive";
};

function ContextMenuItem({
  className,
  inset,
  variant = "default",
  ...props
}: ContextMenuItemProps) {
  return (
    <ContextMenuPrimitive.Item
      data-slot="context-menu-item"
      data-inset={inset}
      data-variant={variant}
      className={cn(
        "relative flex cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "dark:data-[variant=destructive]:focus:bg-destructive/20",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "data-[inset]:pl-8",
        "data-[variant=destructive]:*:[svg]:!text-destructive",
        "data-[variant=destructive]:focus:bg-destructive/10 data-[variant=destructive]:focus:text-destructive",
        "data-[variant=destructive]:text-destructive",
        "[&_svg:not([class*='text-'])]:text-muted-foreground [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuItem;
