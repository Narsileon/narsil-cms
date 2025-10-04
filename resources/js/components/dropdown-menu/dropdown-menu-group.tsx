import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuGroupProps = ComponentProps<typeof DropdownMenu.Group>;

function DropdownMenuGroup({ ...props }: DropdownMenuGroupProps) {
  return <DropdownMenu.Group data-slot="dropdown-menu-group" {...props} />;
}

export default DropdownMenuGroup;
