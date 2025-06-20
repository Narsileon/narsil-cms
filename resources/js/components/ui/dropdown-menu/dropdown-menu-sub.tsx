import { Sub } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuSubProps = React.ComponentProps<typeof Sub> & {};

function DropdownMenuSub({ ...props }: DropdownMenuSubProps) {
  return <Sub data-slot="dropdown-menu-sub" {...props} />;
}

export default DropdownMenuSub;
