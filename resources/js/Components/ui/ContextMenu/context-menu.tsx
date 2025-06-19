import { Root } from "@radix-ui/react-context-menu";

export type ContextMenuProps = React.ComponentProps<typeof Root> & {};

function ContextMenu({ ...props }: ContextMenuProps) {
  return <Root data-slot="context-menu" {...props} />;
}

export default ContextMenu;
