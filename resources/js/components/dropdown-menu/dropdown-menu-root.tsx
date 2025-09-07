import * as React from "react";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuRootProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Root
> & {};

function DropdownMenuRoot({ ...props }: DropdownMenuRootProps) {
  return (
    <DropdownMenuPrimitive.Root data-slot="dropdown-menu-root" {...props} />
  );
}

export default DropdownMenuRoot;
