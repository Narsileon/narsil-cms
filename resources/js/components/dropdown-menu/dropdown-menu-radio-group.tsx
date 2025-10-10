import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuRadioGroupProps = ComponentProps<typeof DropdownMenu.RadioGroup>;

function DropdownMenuRadioGroup({ ...props }: DropdownMenuRadioGroupProps) {
  return <DropdownMenu.RadioGroup data-slot="dropdown-menu-radio-group" {...props} />;
}

export default DropdownMenuRadioGroup;
