import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentPropsWithRef } from "react";

function NavigationMenuList({
  className,
  ...props
}: ComponentPropsWithRef<typeof NavigationMenu.List>) {
  return (
    <NavigationMenu.List
      data-slot="navigation-menu-list"
      className={cn("group flex flex-1 list-none items-center justify-center gap-0", className)}
      {...props}
    />
  );
}

export default NavigationMenuList;
