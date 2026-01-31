import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

type ContextMenuLabelProps = ContextMenu.GroupLabel.Props & {
  inset?: boolean;
};

function ContextMenuLabel({ className, inset, ...props }: ContextMenuLabelProps) {
  return (
    <ContextMenu.GroupLabel
      data-slot="context-menu-group-label"
      data-inset={inset}
      className={cn(
        "px-1.5 py-1 text-xs font-medium text-muted-foreground",
        "data-inset:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuLabel;
