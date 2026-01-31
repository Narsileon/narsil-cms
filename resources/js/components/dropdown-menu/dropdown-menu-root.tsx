import { Menu } from "@base-ui/react/menu";

function DropdownMenuRoot({ ...props }: Menu.Root.Props) {
  return <Menu.Root data-slot="dropdown-menu-root" {...props} />;
}

export default DropdownMenuRoot;
