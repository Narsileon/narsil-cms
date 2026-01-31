import { Menu } from "@base-ui/react/menu";

function DropdownMenuGroup({ ...props }: Menu.Group.Props) {
  return <Menu.Group data-slot="dropdown-menu-group" {...props} />;
}

export default DropdownMenuGroup;
