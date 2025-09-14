import { Menubar } from "radix-ui";

type MenubarRadioGroupProps = React.ComponentProps<
  typeof Menubar.RadioGroup
> & {};

function MenubarRadioGroup({ ...props }: MenubarRadioGroupProps) {
  return <Menubar.RadioGroup data-slot="menubar-radio-group" {...props} />;
}

export default MenubarRadioGroup;
