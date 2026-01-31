import { Menu } from "@base-ui/react/menu";

function DropdownMenuSubmenuRoot({ ...props }: Menu.SubmenuRoot.Props) {
  return <Menu.SubmenuRoot data-slot="dropdown-menu-submenu-root" {...props} />;
}

export default DropdownMenuSubmenuRoot;
