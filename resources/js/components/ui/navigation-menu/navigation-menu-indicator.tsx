import { cn } from "@narsil-cms/lib/utils";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

type NavigationMenuIndicatorProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Indicator
> & {};

function NavigationMenuIndicator({
  className,
  ...props
}: NavigationMenuIndicatorProps) {
  return (
    <NavigationMenuPrimitive.Indicator
      data-slot="navigation-menu-indicator"
      className={cn(
        "top-full z-[1] flex h-1.5 items-end justify-center overflow-hidden",
        "data-[state=hidden]:fade-out data-[state=visible]:fade-in",
        "data-[state=visible]:animate-in data-[state=hidden]:animate-out",
        className,
      )}
      {...props}
    >
      <div className="bg-border relative top-[60%] h-2 w-2 rotate-45 rounded-tl-sm shadow-md" />
    </NavigationMenuPrimitive.Indicator>
  );
}

export default NavigationMenuIndicator;
