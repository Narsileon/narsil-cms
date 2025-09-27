import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuRootProps = ComponentProps<typeof ContextMenu.Root> & {};

function ContextMenuRoot({ ...props }: ContextMenuRootProps) {
  return <ContextMenu.Root data-slot="context-menu-root" {...props} />;
}

export default ContextMenuRoot;
