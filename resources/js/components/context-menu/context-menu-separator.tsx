import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuSeparator({ className, ...props }: ContextMenu.Separator.Props) {
  return (
    <ContextMenu.Separator
      data-slot="context-menu-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
