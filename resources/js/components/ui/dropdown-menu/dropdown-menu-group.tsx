import { Group } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuGroupProps = React.ComponentProps<typeof Group> & {};

function DropdownMenuGroup({ ...props }: DropdownMenuGroupProps) {
  return <Group data-slot="dropdown-menu-group" {...props} />;
}

export default DropdownMenuGroup;
