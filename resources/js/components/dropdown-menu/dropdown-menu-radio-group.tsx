import { Menu } from "@base-ui/react/menu";

function DropdownMenuRadioGroup({ ...props }: Menu.RadioGroup.Props) {
  return <Menu.RadioGroup data-slot="dropdown-menu-radio-group" {...props} />;
}

export default DropdownMenuRadioGroup;
