import { ContextMenu } from "radix-ui";

type ContextMenuSubProps = React.ComponentProps<typeof ContextMenu.Sub> & {};

function ContextMenuSub({ ...props }: ContextMenuSubProps) {
  return <ContextMenu.Sub data-slot="context-menu-sub" {...props} />;
}

export default ContextMenuSub;
