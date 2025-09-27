import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuPortalProps = ComponentProps<typeof ContextMenu.Portal> & {};

function ContextMenuPortal({ ...props }: ContextMenuPortalProps) {
  return <ContextMenu.Portal data-slot="context-menu-portal" {...props} />;
}

export default ContextMenuPortal;
