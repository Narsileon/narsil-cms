import { RadioGroup } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuRadioGroupProps = React.ComponentProps<
  typeof RadioGroup
> & {};

function DropdownMenuRadioGroup({ ...props }: DropdownMenuRadioGroupProps) {
  return <RadioGroup data-slot="dropdown-menu-radio-group" {...props} />;
}

export default DropdownMenuRadioGroup;
