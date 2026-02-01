import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuPopup({ className, ...props }: NavigationMenu.Popup.Props) {
  return (
    <NavigationMenu.Popup
      data-slot="navigation-menu-popup"
      className={cn(
        "relative rounded-lg bg-popover text-popover-foreground shadow ring-1 ring-foreground/10 transition-all duration-300 outline-none",
        "data-ending-style:scale-90 data-ending-style:opacity-0 data-ending-style:duration-150",
        "data-starting-style:scale-90 data-starting-style:opacity-0",
        "xs:w-(--popup-width) h-(--popup-height) w-(--popup-width) origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuPopup;
