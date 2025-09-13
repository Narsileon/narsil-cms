import { ContextMenu } from "radix-ui";

type ContextMenuPortalProps = React.ComponentProps<
  typeof ContextMenu.Portal
> & {};

function ContextMenuPortal({ ...props }: ContextMenuPortalProps) {
  return <ContextMenu.Portal data-slot="context-menu-portal" {...props} />;
}

export default ContextMenuPortal;
