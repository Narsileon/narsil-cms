import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarMenuProps = ComponentProps<typeof Menubar.Menu> & {};

function MenubarMenu({ ...props }: MenubarMenuProps) {
  return <Menubar.Menu data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
