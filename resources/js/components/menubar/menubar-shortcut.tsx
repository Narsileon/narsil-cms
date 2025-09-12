import { cn } from "@narsil-cms/lib/utils";

type MenubarShortcutProps = React.ComponentProps<"span"> & {};

function MenubarShortcut({ className, ...props }: MenubarShortcutProps) {
  return (
    <span
      data-slot="menubar-shortcut"
      className={cn(
        "ml-auto text-xs tracking-widest text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarShortcut;
