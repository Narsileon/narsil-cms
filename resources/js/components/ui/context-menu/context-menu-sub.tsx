import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

export type ContextMenuSubProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Sub
> & {};

function ContextMenuSub({ ...props }: ContextMenuSubProps) {
  return <ContextMenuPrimitive.Sub data-slot="context-menu-sub" {...props} />;
}

export default ContextMenuSub;
