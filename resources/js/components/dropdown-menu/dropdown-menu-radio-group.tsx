import { DropdownMenu } from "radix-ui";

type DropdownMenuRadioGroupProps = React.ComponentProps<
  typeof DropdownMenu.RadioGroup
> & {};

function DropdownMenuRadioGroup({ ...props }: DropdownMenuRadioGroupProps) {
  return (
    <DropdownMenu.RadioGroup data-slot="dropdown-menu-radio-group" {...props} />
  );
}

export default DropdownMenuRadioGroup;
