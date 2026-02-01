import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentPropsWithRef } from "react";

function NavigationMenuItem({
  className,
  ...props
}: ComponentPropsWithRef<typeof NavigationMenu.Item>) {
  return (
    <NavigationMenu.Item
      data-slot="navigation-menu-item"
      className={cn(
        "relative bg-linear-to-r from-transparent to-transparent transition-colors duration-300",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuItem;
