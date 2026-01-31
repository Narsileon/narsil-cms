import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuCheckboxItem({ className, ...props }: ContextMenu.CheckboxItem.Props) {
  return (
    <ContextMenu.CheckboxItem
      data-slot="context-menu-checkbox-item"
      className={cn(
        "relative flex cursor-default items-center gap-1.5 rounded-md py-1 pr-8 pl-1.5 text-sm outline-hidden select-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0",
        "data-disabled:pointer-events-none data-disabled:opacity-50",
        "focus:bg-accent focus:text-accent-foreground",
      )}
      {...props}
    />
  );
}

export default ContextMenuCheckboxItem;
