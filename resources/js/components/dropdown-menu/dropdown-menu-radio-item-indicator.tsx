import { Menu } from "@base-ui/react/menu";
import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";

function DropdownMenuRadioItemIndicator({
  children,
  className,
  ...props
}: Menu.RadioItemIndicator.Props) {
  return (
    <Menu.RadioItemIndicator
      data-slot="dropdown-menu-radio-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex items-center justify-center",
        className,
      )}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </Menu.RadioItemIndicator>
  );
}

export default DropdownMenuRadioItemIndicator;
