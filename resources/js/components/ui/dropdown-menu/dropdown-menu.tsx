import * as React from "react";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Root
> & {};

function DropdownMenu({ ...props }: DropdownMenuProps) {
  return <DropdownMenuPrimitive.Root data-slot="dropdown-menu" {...props} />;
}

export default DropdownMenu;
