import { Trigger } from "@radix-ui/react-context-menu";

export type ContextMenuTriggerProps = React.ComponentProps<typeof Trigger> & {};

function ContextMenuTrigger({ ...props }: ContextMenuTriggerProps) {
  return <Trigger data-slot="context-menu-trigger" {...props} />;
}

export default ContextMenuTrigger;
