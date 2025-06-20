import { cn } from "@/components";

export type MenubarShortcutProps = React.ComponentProps<"span"> & {};

function MenubarShortcut({ className, ...props }: MenubarShortcutProps) {
  return (
    <span
      data-slot="menubar-shortcut"
      className={cn(
        "text-muted-foreground ml-auto text-xs tracking-widest",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarShortcut;
