import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuTriggerProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Trigger
> & {};

function DropdownMenuTrigger({ ...props }: DropdownMenuTriggerProps) {
  return (
    <DropdownMenuPrimitive.Trigger
      data-slot="dropdown-menu-trigger"
      {...props}
    />
  );
}

export default DropdownMenuTrigger;
