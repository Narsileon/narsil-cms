import { Menu } from "@base-ui/react/menu";

function MenubarPortal({ ...props }: Menu.Portal.Props) {
  return <Menu.Portal data-slot="menubar-portal" {...props} />;
}

export default MenubarPortal;
