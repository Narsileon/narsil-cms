import { ContextMenu } from "radix-ui";

type ContextMenuTriggerProps = React.ComponentProps<
  typeof ContextMenu.Trigger
> & {};

function ContextMenuTrigger({ ...props }: ContextMenuTriggerProps) {
  return <ContextMenu.Trigger data-slot="context-menu-trigger" {...props} />;
}

export default ContextMenuTrigger;
