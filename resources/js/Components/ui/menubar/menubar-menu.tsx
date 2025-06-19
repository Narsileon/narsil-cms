import { Menu } from "@radix-ui/react-menubar";

export type MenubarMenuProps = React.ComponentProps<typeof Menu> & {};

function MenubarMenu({ ...props }: MenubarMenuProps) {
  return <Menu data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
