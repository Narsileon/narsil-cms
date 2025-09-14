import { DropdownMenu } from "radix-ui";

type DropdownMenuRootProps = React.ComponentProps<
  typeof DropdownMenu.Root
> & {};

function DropdownMenuRoot({ ...props }: DropdownMenuRootProps) {
  return <DropdownMenu.Root data-slot="dropdown-menu-root" {...props} />;
}

export default DropdownMenuRoot;
