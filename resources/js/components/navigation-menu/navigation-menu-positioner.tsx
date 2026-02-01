import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuPositioner({
  className,
  align = "start",
  alignOffset = 0,
  side = "bottom",
  sideOffset = 8,
  ...props
}: NavigationMenu.Positioner.Props) {
  return (
    <NavigationMenu.Positioner
      data-slot="navigation-menu-positioner"
      className={cn(
        "isolate z-50 transition-[top,left,right,bottom] duration-300",
        "h-(--positioner-height) w-(--positioner-width) max-w-(--available-width)",
        "data-instant:transition-none data-[side=bottom]:before:-top-2.5 data-[side=bottom]:before:right-0 data-[side=bottom]:before:left-0",
        className,
      )}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default NavigationMenuPositioner;
