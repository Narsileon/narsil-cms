import * as React from "react";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarGroupProps = React.ComponentProps<
  typeof MenubarPrimitive.Group
> & {};

function MenubarGroup({ ...props }: MenubarGroupProps) {
  return <MenubarPrimitive.Group data-slot="menubar-group" {...props} />;
}

export default MenubarGroup;
