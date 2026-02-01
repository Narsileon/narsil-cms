import { NavigationMenu } from "@base-ui/react/navigation-menu";

function NavigationMenuPortal({ ...props }: NavigationMenu.Portal.Props) {
  return <NavigationMenu.Portal data-slot="navigation-menu-portal" {...props} />;
}

export default NavigationMenuPortal;
