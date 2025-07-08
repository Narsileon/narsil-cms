import { cn } from "@/lib/utils";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

type NavigationMenuItemProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Item
> & {};

function NavigationMenuItem({ className, ...props }: NavigationMenuItemProps) {
  return (
    <NavigationMenuPrimitive.Item
      data-slot="navigation-menu-item"
      className={cn("relative", className)}
      {...props}
    />
  );
}

export default NavigationMenuItem;
