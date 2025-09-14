import { DropdownMenu } from "radix-ui";

type DropdownMenuSubProps = React.ComponentProps<typeof DropdownMenu.Sub> & {};

function DropdownMenuSub({ ...props }: DropdownMenuSubProps) {
  return <DropdownMenu.Sub data-slot="dropdown-menu-sub" {...props} />;
}

export default DropdownMenuSub;
