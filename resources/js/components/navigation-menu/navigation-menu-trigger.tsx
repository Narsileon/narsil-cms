import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";
import navigationMenuTriggerVariants from "./navigation-menu-trigger-variants";

function NavigationMenuTrigger({ className, ...props }: NavigationMenu.Trigger.Props) {
  return (
    <NavigationMenu.Trigger
      data-slot="navigation-menu-trigger"
      className={cn(navigationMenuTriggerVariants(), "group", className)}
      {...props}
    />
  );
}

export default NavigationMenuTrigger;
