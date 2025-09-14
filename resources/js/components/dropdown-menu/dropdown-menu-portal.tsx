import { DropdownMenu } from "radix-ui";

type DropdownMenuPortalProps = React.ComponentProps<
  typeof DropdownMenu.Portal
> & {};

function DropdownMenuPortal({ ...props }: DropdownMenuPortalProps) {
  return <DropdownMenu.Portal data-slot="dropdown-menu-portal" {...props} />;
}

export default DropdownMenuPortal;
