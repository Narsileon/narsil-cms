import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type ShortcutRootProps = ComponentProps<"span"> & {};

function ShortcutRoot({ className, ...props }: ShortcutRootProps) {
  return (
    <span
      data-slot="shortcut-root"
      className={cn(
        "text-muted-foreground ml-auto text-xs tracking-widest",
        className,
      )}
      {...props}
    />
  );
}

export default ShortcutRoot;
