import { cn } from "@/components";
import { Item } from "@radix-ui/react-navigation-menu";

export interface NavigationMenuItemProps
  extends React.ComponentProps<typeof Item> {}

function NavigationMenuItem({ className, ...props }: NavigationMenuItemProps) {
  return (
    <Item
      data-slot="navigation-menu-item"
      className={cn("relative", className)}
      {...props}
    />
  );
}

export default NavigationMenuItem;
