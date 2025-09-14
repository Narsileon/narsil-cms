import { NavigationMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import NavigationMenuViewport from "./navigation-menu-viewport";

type NavigationMenuRootProps = React.ComponentProps<
  typeof NavigationMenu.Root
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
    <NavigationMenu.Root
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
    </NavigationMenu.Root>
  );
}

export default NavigationMenuRoot;
