import { cn } from "@narsil-cms/lib/utils";
import { NavigationMenu } from "radix-ui";
import { type ComponentProps } from "react";

type NavigationMenuLinkProps = ComponentProps<typeof NavigationMenu.Link>;

function NavigationMenuLink({ className, ...props }: NavigationMenuLinkProps) {
  return (
    <NavigationMenu.Link
      data-slot="navigation-menu-link"
      className={cn(
        "hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus-visible:ring-ring/50 data-[active=true]:bg-accent/50 data-[active=true]:text-accent-foreground data-[active=true]:hover:bg-accent data-[active=true]:focus:bg-accent [&_svg:not([class*='text-'])]:text-muted-foreground flex flex-col gap-1 rounded-md p-2 outline-none transition-all focus-visible:outline-1 focus-visible:ring-2 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuLink;
