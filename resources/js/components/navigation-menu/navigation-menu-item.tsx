import { NavigationMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type NavigationMenuItemProps = React.ComponentProps<
  typeof NavigationMenu.Item
> & {};

function NavigationMenuItem({ className, ...props }: NavigationMenuItemProps) {
  return (
    <NavigationMenu.Item
      data-slot="navigation-menu-item"
      className={cn("relative", className)}
      {...props}
    />
  );
}

export default NavigationMenuItem;
