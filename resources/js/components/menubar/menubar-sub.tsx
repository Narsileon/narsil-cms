import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarSubProps = ComponentProps<typeof Menubar.Sub>;

function MenubarSub({ ...props }: MenubarSubProps) {
  return <Menubar.Sub data-slot="menubar-sub" {...props} />;
}

export default MenubarSub;
