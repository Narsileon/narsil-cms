import { Menu } from "@radix-ui/react-menubar";

export type MenubarMenuProps = React.ComponentProps<typeof Menu> & {};

function MenubarMenu({ ...props }: React.ComponentProps<typeof Menu>) {
  return <Menu data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
