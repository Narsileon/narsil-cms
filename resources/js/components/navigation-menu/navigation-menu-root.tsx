import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuRoot({ className, ...props }: NavigationMenu.Root.Props) {
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
