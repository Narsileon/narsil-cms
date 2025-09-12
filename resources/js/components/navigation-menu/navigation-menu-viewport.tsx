import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type NavigationMenuViewportProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Viewport
> & {};

function NavigationMenuViewport({
  className,
  ...props
}: NavigationMenuViewportProps) {
  return (
    <div
      className={cn(
        "absolute top-full left-0 isolate z-50 flex justify-center",
      )}
    >
      <NavigationMenuPrimitive.Viewport
        data-slot="navigation-menu-viewport"
        className={cn(
          "origin-top-center relative mt-1.5 h-[var(--radix-navigation-menu-viewport-height)] w-full overflow-hidden rounded-md border bg-popover text-popover-foreground shadow md:w-[var(--radix-navigation-menu-viewport-width)]",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-90",
          className,
        )}
        {...props}
      />
    </div>
  );
}

export default NavigationMenuViewport;
