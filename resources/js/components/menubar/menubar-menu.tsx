import { Menubar } from "radix-ui";

type MenubarMenuProps = React.ComponentProps<typeof Menubar.Menu> & {};

function MenubarMenu({ ...props }: MenubarMenuProps) {
  return <Menubar.Menu data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
