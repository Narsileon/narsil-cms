import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuSubTriggerProps = Menu.SubmenuTrigger.Props & {
  inset?: boolean;
};

function DropdownMenuSubmenuTrigger({ className, inset, ...props }: DropdownMenuSubTriggerProps) {
  return (
    <Menu.SubmenuTrigger
      data-slot="dropdown-menu-submenu-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-default items-center gap-1.5 rounded-md px-1.5 py-1 text-sm outline-hidden select-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0",
        "data-inset:pl-8",
        "data-open:bg-accent data-open:text-accent-foreground",
        "data-popup-open:bg-accent data-popup-open:text-accent-foreground",
        "focus:bg-accent focus:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuSubmenuTrigger;
