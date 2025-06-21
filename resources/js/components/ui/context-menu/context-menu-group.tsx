import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

export type ContextMenuGroupProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Group
> & {};

function ContextMenuGroup({ ...props }: ContextMenuGroupProps) {
  return (
    <ContextMenuPrimitive.Group data-slot="context-menu-group" {...props} />
  );
}

export default ContextMenuGroup;
