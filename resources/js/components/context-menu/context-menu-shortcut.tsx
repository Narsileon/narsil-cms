import * as React from "react";
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
        "text-muted-foreground ml-auto text-xs tracking-widest",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuShortcut;
