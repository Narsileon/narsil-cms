import { Menubar as MenubarPrimitive } from "radix-ui";

export type MenubarSubProps = React.ComponentProps<
  typeof MenubarPrimitive.Sub
> & {};

function MenubarSub({ ...props }: MenubarSubProps) {
  return <MenubarPrimitive.Sub data-slot="menubar-sub" {...props} />;
}

export default MenubarSub;
