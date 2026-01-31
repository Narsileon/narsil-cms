import { Menu } from "@base-ui/react/menu";

function MenubarMenu({ ...props }: Menu.Root.Props) {
  return <Menu.Root data-slot="menubar-menu" {...props} />;
}

export default MenubarMenu;
