import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuTrigger({ className, ...props }: ContextMenu.Trigger.Props) {
  return (
    <ContextMenu.Trigger
      data-slot="context-menu-trigger"
      className={cn("select-none", className)}
      {...props}
    />
  );
}

export default ContextMenuTrigger;
