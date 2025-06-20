import { cn } from "@/Components";
import { Root } from "@radix-ui/react-navigation-menu";
import NavigationMenuViewport from "./navigation-menu-viewport";

export type NavigationMenuProps = React.ComponentProps<typeof Root> & {
  viewport?: boolean;
};

function NavigationMenu({
  className,
  children,
  viewport = true,
  ...props
}: NavigationMenuProps) {
  return (
    <Root
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
    </Root>
  );
}

export default NavigationMenu;
