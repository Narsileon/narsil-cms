import * as React from "react";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuTriggerProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Trigger
> & {};

function ContextMenuTrigger({ ...props }: ContextMenuTriggerProps) {
  return (
    <ContextMenuPrimitive.Trigger data-slot="context-menu-trigger" {...props} />
  );
}

export default ContextMenuTrigger;
