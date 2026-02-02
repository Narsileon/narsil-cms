import { Menu } from "@base-ui/react/menu";
import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";

function MenubarRadioItemIndicator({
  children,
  className,
  ...props
}: Menu.RadioItemIndicator.Props) {
  return (
    <Menu.RadioItemIndicator
      data-slot="menubar-radio-item-indicator"
      className={cn(
        "pointer-events-none absolute left-1.5 flex size-4 items-center justify-center",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </Menu.RadioItemIndicator>
  );
}

export default MenubarRadioItemIndicator;
