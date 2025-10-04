import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuSubProps = ComponentProps<typeof DropdownMenu.Sub>;

function DropdownMenuSub({ ...props }: DropdownMenuSubProps) {
  return <DropdownMenu.Sub data-slot="dropdown-menu-sub" {...props} />;
}

export default DropdownMenuSub;
