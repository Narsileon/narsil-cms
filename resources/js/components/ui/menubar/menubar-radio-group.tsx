import { RadioGroup } from "@radix-ui/react-menubar";

export type MenubarRadioGroupProps = React.ComponentProps<
  typeof RadioGroup
> & {};

function MenubarRadioGroup({ ...props }: MenubarRadioGroupProps) {
  return <RadioGroup data-slot="menubar-radio-group" {...props} />;
}

export default MenubarRadioGroup;
