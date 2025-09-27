import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuGroupProps = ComponentProps<typeof ContextMenu.Group> & {};

function ContextMenuGroup({ ...props }: ContextMenuGroupProps) {
  return <ContextMenu.Group data-slot="context-menu-group" {...props} />;
}

export default ContextMenuGroup;
