import { cn } from "@/lib/utils";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";
import NavigationMenuViewport from "./navigation-menu-viewport";

export type NavigationMenuProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Root
> & {
  viewport?: boolean;
};

function NavigationMenu({
  className,
  children,
  viewport = true,
  ...props
}: NavigationMenuProps) {
  return (
    <NavigationMenuPrimitive.Root
      data-slot="navigation-menu"
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

export default NavigationMenu;
