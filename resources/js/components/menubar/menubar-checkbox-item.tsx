import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function MenubarCheckboxItem({ className, ...props }: Menu.CheckboxItem.Props) {
  return (
    <Menu.CheckboxItem
      data-slot="menubar-checkbox-item"
      className={cn(
        "relative flex cursor-default items-center gap-1.5 rounded-md py-1 pr-1.5 pl-7 text-sm outline-hidden select-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0",
        "data-disabled:pointer-events-none data-disabled:opacity-50",
        "focus:bg-accent focus:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarCheckboxItem;
