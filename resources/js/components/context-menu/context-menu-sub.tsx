import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuSubProps = ComponentProps<typeof ContextMenu.Sub> & {};

function ContextMenuSub({ ...props }: ContextMenuSubProps) {
  return <ContextMenu.Sub data-slot="context-menu-sub" {...props} />;
}

export default ContextMenuSub;
