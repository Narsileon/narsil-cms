import { NavigationMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type NavigationMenuListProps = React.ComponentProps<
  typeof NavigationMenu.List
> & {};

function NavigationMenuList({ className, ...props }: NavigationMenuListProps) {
  return (
    <NavigationMenu.List
      data-slot="navigation-menu-list"
      className={cn(
        "group flex flex-1 list-none items-center justify-center gap-1",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuList;
