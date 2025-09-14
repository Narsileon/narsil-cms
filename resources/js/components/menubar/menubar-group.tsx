import { Menubar } from "radix-ui";

type MenubarGroupProps = React.ComponentProps<typeof Menubar.Group> & {};

function MenubarGroup({ ...props }: MenubarGroupProps) {
  return <Menubar.Group data-slot="menubar-group" {...props} />;
}

export default MenubarGroup;
