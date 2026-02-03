import { Menu } from "@base-ui/react/menu";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function MenubarCheckboxItemIndicator({
  children,
  className,
  ...props
}: Menu.CheckboxItemIndicator.Props) {
  return (
    <Menu.CheckboxItemIndicator
      data-slot="menubar-checkbox-item-indicator"
      className={cn(
        "pointer-events-none absolute left-1.5 flex size-4 items-center justify-center",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </Menu.CheckboxItemIndicator>
  );
}

export default MenubarCheckboxItemIndicator;
