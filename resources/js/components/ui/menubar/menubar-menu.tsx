import { Menubar as MenubarPrimitive } from "radix-ui";

export type MenubarMenuProps = React.ComponentProps<
  typeof MenubarPrimitive.Menu
> & {};

function MenubarMenu({ ...props }: MenubarMenuProps) {
  return <MenubarPrimitive.Menu data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
