import { cn } from "@narsil-cms/lib/utils";

type ContextMenuShortcutProps = React.ComponentProps<"span"> & {};

function ContextMenuShortcut({
  className,
  ...props
}: ContextMenuShortcutProps) {
  return (
    <span
      data-slot="context-menu-shortcut"
      className={cn(
        "ml-auto text-xs tracking-widest text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuShortcut;
