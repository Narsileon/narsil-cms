import { NavigationMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type NavigationMenuIndicatorProps = React.ComponentProps<
  typeof NavigationMenu.Indicator
> & {};

function NavigationMenuIndicator({
  className,
  ...props
}: NavigationMenuIndicatorProps) {
  return (
    <NavigationMenu.Indicator
      data-slot="navigation-menu-indicator"
      className={cn(
        "top-full z-[1] flex h-1.5 items-end justify-center overflow-hidden",
        "data-[state=hidden]:fade-out data-[state=visible]:fade-in",
        "data-[state=visible]:animate-in data-[state=hidden]:animate-out",
        className,
      )}
      {...props}
    >
      <div className="relative top-[60%] h-2 w-2 rotate-45 rounded-tl-sm bg-border shadow-md" />
    </NavigationMenu.Indicator>
  );
}

export default NavigationMenuIndicator;
