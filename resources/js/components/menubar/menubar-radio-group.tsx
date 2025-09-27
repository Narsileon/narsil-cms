import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarRadioGroupProps = ComponentProps<typeof Menubar.RadioGroup> & {};

function MenubarRadioGroup({ ...props }: MenubarRadioGroupProps) {
  return <Menubar.RadioGroup data-slot="menubar-radio-group" {...props} />;
}

export default MenubarRadioGroup;
