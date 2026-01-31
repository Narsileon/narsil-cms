import { ContextMenu } from "@base-ui/react/context-menu";

function ContextMenuSubmenuRoot({ ...props }: ContextMenu.SubmenuRoot.Props) {
  return <ContextMenu.SubmenuRoot data-slot="context-menu-submenu-root" {...props} />;
}

export default ContextMenuSubmenuRoot;
