import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuViewport({ className, ...props }: NavigationMenu.Viewport.Props) {
  return (
    <NavigationMenu.Viewport
      data-slot="navigation-menu-viewport"
      className={cn("relative size-full overflow-hidden", className)}
      {...props}
    />
  );
}

export default NavigationMenuViewport;
