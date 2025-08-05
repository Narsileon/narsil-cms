import * as React from "react";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarRadioGroupProps = React.ComponentProps<
  typeof MenubarPrimitive.RadioGroup
> & {};

function MenubarRadioGroup({ ...props }: MenubarRadioGroupProps) {
  return (
    <MenubarPrimitive.RadioGroup data-slot="menubar-radio-group" {...props} />
  );
}

export default MenubarRadioGroup;
