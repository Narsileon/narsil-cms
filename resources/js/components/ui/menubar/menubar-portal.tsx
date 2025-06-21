import { Menubar as MenubarPrimitive } from "radix-ui";

export type MenubarPortalProps = React.ComponentProps<
  typeof MenubarPrimitive.Portal
> & {};

function MenubarPortal({ ...props }: MenubarPortalProps) {
  return <MenubarPrimitive.Portal data-slot="menubar-portal" {...props} />;
}

export default MenubarPortal;
