import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

type NavigationMenuLinkProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Link
> & {};

function NavigationMenuLink({ className, ...props }: NavigationMenuLinkProps) {
  return (
    <NavigationMenuPrimitive.Link
      data-slot="navigation-menu-link"
      className={cn(
        "data-[active=true]:focus:bg-accent data-[active=true]:hover:bg-accent data-[active=true]:bg-accent/50 data-[active=true]:text-accent-foreground hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus-visible:ring-ring/50 [&_svg:not([class*='text-'])]:text-muted-foreground flex flex-col gap-1 rounded-md p-2 text-sm transition-all outline-none focus-visible:ring-2 focus-visible:outline-1 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuLink;
