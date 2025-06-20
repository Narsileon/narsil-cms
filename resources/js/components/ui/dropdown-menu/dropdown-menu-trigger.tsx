import { Trigger } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuTriggerProps = React.ComponentProps<
  typeof Trigger
> & {};

function DropdownMenuTrigger({ ...props }: DropdownMenuTriggerProps) {
  return <Trigger data-slot="dropdown-menu-trigger" {...props} />;
}

export default DropdownMenuTrigger;
