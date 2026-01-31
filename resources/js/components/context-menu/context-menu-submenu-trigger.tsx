import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

type ContextMenuSubmenuTriggerProps = ContextMenu.SubmenuTrigger.Props & {
  inset?: boolean;
};

function ContextMenuSubmenuTrigger({ className, inset, ...props }: ContextMenuSubmenuTriggerProps) {
  return (
    <ContextMenu.SubmenuTrigger
      data-slot="context-menu-submenu-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-default items-center gap-1.5 rounded-md px-1.5 py-1 text-sm outline-hidden select-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0",
        "data-inset:pl-8",
        "data-open:bg-accent data-open:text-accent-foreground",
        "focus:bg-accent focus:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuSubmenuTrigger;
