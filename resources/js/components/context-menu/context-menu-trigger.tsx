import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuTriggerProps = ComponentProps<typeof ContextMenu.Trigger>;

function ContextMenuTrigger({ ...props }: ContextMenuTriggerProps) {
  return <ContextMenu.Trigger data-slot="context-menu-trigger" {...props} />;
}

export default ContextMenuTrigger;
