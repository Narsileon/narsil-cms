import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuShortcutProps = React.ComponentProps<"span"> & {};

function DropdownMenuShortcut({
  className,
  ...props
}: DropdownMenuShortcutProps) {
  return (
    <span
      data-slot="dropdown-menu-shortcut"
      className={cn(
        "ml-auto text-xs tracking-widest text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuShortcut;
