import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarGroupProps = ComponentProps<typeof Menubar.Group> & {};

function MenubarGroup({ ...props }: MenubarGroupProps) {
  return <Menubar.Group data-slot="menubar-group" {...props} />;
}

export default MenubarGroup;
