import { Menu } from "@base-ui/react/menu";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function DropdownMenuCheckboxItemIndicator({
  children,
  className,
  ...props
}: Menu.CheckboxItemIndicator.Props) {
  return (
    <Menu.CheckboxItemIndicator
      data-slot="dropdown-menu-checkbox-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex items-center justify-center",
        className,
      )}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </Menu.CheckboxItemIndicator>
  );
}

export default DropdownMenuCheckboxItemIndicator;
