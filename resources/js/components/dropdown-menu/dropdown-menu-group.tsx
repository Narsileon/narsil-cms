import { DropdownMenu } from "radix-ui";

type DropdownMenuGroupProps = React.ComponentProps<
  typeof DropdownMenu.Group
> & {};

function DropdownMenuGroup({ ...props }: DropdownMenuGroupProps) {
  return <DropdownMenu.Group data-slot="dropdown-menu-group" {...props} />;
}

export default DropdownMenuGroup;
