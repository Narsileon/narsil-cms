import * as React from "react";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuSubProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Sub
> & {};

function DropdownMenuSub({ ...props }: DropdownMenuSubProps) {
  return <DropdownMenuPrimitive.Sub data-slot="dropdown-menu-sub" {...props} />;
}

export default DropdownMenuSub;
