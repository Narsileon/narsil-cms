import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarPortalProps = ComponentProps<typeof Menubar.Portal>;

function MenubarPortal({ ...props }: MenubarPortalProps) {
  return <Menubar.Portal data-slot="menubar-portal" {...props} />;
}

export default MenubarPortal;
