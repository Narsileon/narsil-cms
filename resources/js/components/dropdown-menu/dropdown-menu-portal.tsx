import { Menu } from "@base-ui/react/menu";

function DropdownMenuPortal({ ...props }: Menu.Portal.Props) {
  return <Menu.Portal data-slot="dropdown-menu-portal" {...props} />;
}

export default DropdownMenuPortal;
