import { Menu } from "@base-ui/react/menu";

function MenubarRadioGroup({ ...props }: Menu.RadioGroup.Props) {
  return <Menu.RadioGroup data-slot="menubar-radio-group" {...props} />;
}

export default MenubarRadioGroup;
