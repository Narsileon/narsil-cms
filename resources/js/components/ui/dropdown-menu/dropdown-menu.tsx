import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

export type DropdownMenuProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Root
> & {};

function DropdownMenu({ ...props }: DropdownMenuProps) {
  return <DropdownMenuPrimitive.Root data-slot="dropdown-menu" {...props} />;
}

export default DropdownMenu;
