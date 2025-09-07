import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";
import NavigationMenuViewport from "./navigation-menu-viewport";

type NavigationMenuRootProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Root
> & {
  viewport?: boolean;
};

function NavigationMenuRoot({
  className,
  children,
  viewport = true,
  ...props
}: NavigationMenuRootProps) {
  return (
    <NavigationMenuPrimitive.Root
      data-slot="navigation-menu-root"
      data-viewport={viewport}
      className={cn(
        "group/navigation-menu relative flex max-w-max flex-1 items-center justify-center",
        className,
      )}
      {...props}
    >
      {children}
      {viewport && <NavigationMenuViewport />}
    </NavigationMenuPrimitive.Root>
  );
}

export default NavigationMenuRoot;
