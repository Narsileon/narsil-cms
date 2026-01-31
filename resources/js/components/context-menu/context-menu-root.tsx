import { ContextMenu } from "@base-ui/react/context-menu";

function ContextMenuRoot({ ...props }: ContextMenu.Root.Props) {
  return <ContextMenu.Root data-slot="context-menu-root" {...props} />;
}

export default ContextMenuRoot;
