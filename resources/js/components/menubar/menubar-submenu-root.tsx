import { Menu } from "@base-ui/react/menu";

function MenubarSubmenuRoot({ ...props }: Menu.SubmenuRoot.Props) {
  return <Menu.SubmenuRoot data-slot="menubar-submenu-root" {...props} />;
}

export default MenubarSubmenuRoot;
