import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ContextMenuSeparatorProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Separator
> & {};

function ContextMenuSeparator({
  className,
  ...props
}: ContextMenuSeparatorProps) {
  return (
    <ContextMenuPrimitive.Separator
      data-slot="context-menu-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
