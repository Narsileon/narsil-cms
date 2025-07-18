import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Root
> & {};

function ContextMenu({ ...props }: ContextMenuProps) {
  return <ContextMenuPrimitive.Root data-slot="context-menu" {...props} />;
}

export default ContextMenu;
