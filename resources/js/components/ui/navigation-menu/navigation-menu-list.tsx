import { cn } from "@/components";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

export type NavigationMenuListProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.List
> & {};

function NavigationMenuList({ className, ...props }: NavigationMenuListProps) {
  return (
    <NavigationMenuPrimitive.List
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
