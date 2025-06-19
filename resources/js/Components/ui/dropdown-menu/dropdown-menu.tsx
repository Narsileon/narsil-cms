import { Root } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuProps = React.ComponentProps<typeof Root> & {};

function DropdownMenu({ ...props }: DropdownMenuProps) {
  return <Root data-slot="dropdown-menu" {...props} />;
}

export default DropdownMenu;
