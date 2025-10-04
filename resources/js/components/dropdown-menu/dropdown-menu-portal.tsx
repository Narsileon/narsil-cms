import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuPortalProps = ComponentProps<typeof DropdownMenu.Portal>;

function DropdownMenuPortal({ ...props }: DropdownMenuPortalProps) {
  return <DropdownMenu.Portal data-slot="dropdown-menu-portal" {...props} />;
}

export default DropdownMenuPortal;
