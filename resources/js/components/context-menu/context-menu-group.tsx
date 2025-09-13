import { ContextMenu } from "radix-ui";

type ContextMenuGroupProps = React.ComponentProps<
  typeof ContextMenu.Group
> & {};

function ContextMenuGroup({ ...props }: ContextMenuGroupProps) {
  return <ContextMenu.Group data-slot="context-menu-group" {...props} />;
}

export default ContextMenuGroup;
