import * as React from "react";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuRootProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Root
> & {};

function ContextMenuRoot({ ...props }: ContextMenuRootProps) {
  return <ContextMenuPrimitive.Root data-slot="context-menu-root" {...props} />;
}

export default ContextMenuRoot;
