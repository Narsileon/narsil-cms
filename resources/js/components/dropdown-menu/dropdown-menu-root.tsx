import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuRootProps = ComponentProps<typeof DropdownMenu.Root> & {};

function DropdownMenuRoot({ ...props }: DropdownMenuRootProps) {
  return <DropdownMenu.Root data-slot="dropdown-menu-root" {...props} />;
}

export default DropdownMenuRoot;
