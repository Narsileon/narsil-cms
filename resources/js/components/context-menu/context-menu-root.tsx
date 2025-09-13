import { ContextMenu } from "radix-ui";

type ContextMenuRootProps = React.ComponentProps<typeof ContextMenu.Root> & {};

function ContextMenuRoot({ ...props }: ContextMenuRootProps) {
  return <ContextMenu.Root data-slot="context-menu-root" {...props} />;
}

export default ContextMenuRoot;
