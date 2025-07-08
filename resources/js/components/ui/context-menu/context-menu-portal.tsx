import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuPortalProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Portal
> & {};

function ContextMenuPortal({ ...props }: ContextMenuPortalProps) {
  return (
    <ContextMenuPrimitive.Portal data-slot="context-menu-portal" {...props} />
  );
}

export default ContextMenuPortal;
