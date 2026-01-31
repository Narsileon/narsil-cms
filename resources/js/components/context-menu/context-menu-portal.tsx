import { ContextMenu } from "@base-ui/react/context-menu";

function ContextMenuPortal({ ...props }: ContextMenu.Portal.Props) {
  return <ContextMenu.Portal data-slot="context-menu-portal" {...props} />;
}

export default ContextMenuPortal;
