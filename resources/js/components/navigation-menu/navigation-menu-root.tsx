import { NavigationMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type NavigationMenuRootProps = React.ComponentProps<
  typeof NavigationMenu.Root
> & {};

function NavigationMenuRoot({ className, ...props }: NavigationMenuRootProps) {
  return (
    <NavigationMenu.Root
      data-slot="navigation-menu-root"
      className={cn(
        "group/navigation-menu relative flex max-w-max flex-1 items-center justify-center",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuRoot;
