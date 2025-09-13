import { ContextMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ContextMenuSeparatorProps = React.ComponentProps<
  typeof ContextMenu.Separator
> & {};

function ContextMenuSeparator({
  className,
  ...props
}: ContextMenuSeparatorProps) {
  return (
    <ContextMenu.Separator
      data-slot="context-menu-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
