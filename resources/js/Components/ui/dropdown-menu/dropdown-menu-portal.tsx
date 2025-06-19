import { Portal } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuPortalProps = React.ComponentProps<typeof Portal> & {};

function DropdownMenuPortal({ ...props }: DropdownMenuPortalProps) {
  return <Portal data-slot="dropdown-menu-portal" {...props} />;
}

export default DropdownMenuPortal;
