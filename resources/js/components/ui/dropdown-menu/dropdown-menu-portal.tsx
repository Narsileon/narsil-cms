import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuPortalProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Portal
> & {};

function DropdownMenuPortal({ ...props }: DropdownMenuPortalProps) {
  return (
    <DropdownMenuPrimitive.Portal data-slot="dropdown-menu-portal" {...props} />
  );
}

export default DropdownMenuPortal;
