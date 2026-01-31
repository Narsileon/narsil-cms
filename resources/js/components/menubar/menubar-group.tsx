import { Menu } from "@base-ui/react/menu";

function MenubarGroup({ ...props }: Menu.Group.Props) {
  return <Menu.Group data-slot="menubar-group" {...props} />;
}

export default MenubarGroup;
