import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuLink({ className, ...props }: NavigationMenu.Link.Props) {
  return (
    <NavigationMenu.Link
      data-slot="navigation-menu-link"
      className={cn(
        "flex items-center gap-2 rounded-lg p-2 transition-all outline-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "data-active:text-primary",
        "focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-1",
        "hover:text-primary",
        "in-data-[slot=navigation-menu-content]:rounded-md",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuLink;
