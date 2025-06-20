import { cn } from "@/Components";
import { List } from "@radix-ui/react-navigation-menu";

export type NavigationMenuListProps = React.ComponentProps<typeof List> & {};

function NavigationMenuList({ className, ...props }: NavigationMenuListProps) {
  return (
    <List
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
