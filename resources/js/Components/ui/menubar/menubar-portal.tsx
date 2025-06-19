import { Portal } from "@radix-ui/react-menubar";

export type MenubarPortalProps = React.ComponentProps<typeof Portal> & {};

function MenubarPortal({ ...props }: MenubarPortalProps) {
  return <Portal data-slot="menubar-portal" {...props} />;
}

export default MenubarPortal;
