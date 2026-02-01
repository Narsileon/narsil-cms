import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuLink({ className, ...props }: NavigationMenu.Link.Props) {
  return (
    <NavigationMenu.Link
      data-slot="navigation-menu-link"
      className={cn(
        "flex items-center gap-2 rounded-lg p-2 text-sm transition-all outline-none",
        "[&_svg:not([class*='size-'])]:size-4",
        "data-active:bg-muted/50",
        "data-active:focus:bg-muted",
        "data-active:hover:bg-muted",
        "focus:bg-muted focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-1",
        "hover:bg-muted",
        "in-data-[slot=navigation-menu-content]:rounded-md",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuLink;
