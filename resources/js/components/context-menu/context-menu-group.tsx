import { ContextMenu } from "@base-ui/react/context-menu";

function ContextMenuGroup({ ...props }: ContextMenu.Group.Props) {
  return <ContextMenu.Group data-slot="context-menu-group" {...props} />;
}

export default ContextMenuGroup;
