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
        "text-muted-foreground ml-auto text-xs tracking-widest",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuShortcut;
