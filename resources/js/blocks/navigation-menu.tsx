import {
  NavigationMenuContent,
  NavigationMenuItem,
  NavigationMenuList,
  NavigationMenuRoot,
  NavigationMenuTrigger,
  NavigationMenuViewport,
} from "@narsil-cms/components/navigation-menu";
type NavigationMenuElement = {
  title: string;
  content: React.ReactNode;
};

type NavigationMenuProps = React.ComponentProps<typeof NavigationMenuRoot> & {
  elements: NavigationMenuElement[];
  viewport?: boolean;
};

function NavigationMenu({
  elements,
  viewport = true,
  ...props
}: NavigationMenuProps) {
  return (
    <NavigationMenuRoot data-viewport={viewport} {...props}>
      <NavigationMenuList>
        {elements.map((element, index) => (
          <NavigationMenuItem key={index}>
            <NavigationMenuTrigger>{element.title}</NavigationMenuTrigger>
            <NavigationMenuContent>{element.content}</NavigationMenuContent>
          </NavigationMenuItem>
        ))}
      </NavigationMenuList>
      {viewport ? <NavigationMenuViewport /> : null}
    </NavigationMenuRoot>
  );
}

export default NavigationMenu;
