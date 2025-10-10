import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuRootProps = ComponentProps<typeof DropdownMenu.Root>;

function DropdownMenuRoot({ modal = false, ...props }: DropdownMenuRootProps) {
  return <DropdownMenu.Root data-slot="dropdown-menu-root" modal={modal} {...props} />;
}

export default DropdownMenuRoot;
