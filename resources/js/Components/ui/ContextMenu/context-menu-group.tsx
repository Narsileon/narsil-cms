import { Group } from "@radix-ui/react-context-menu";

export type ContextMenuGroupProps = React.ComponentProps<typeof Group> & {};

function ContextMenuGroup({ ...props }: ContextMenuGroupProps) {
  return <Group data-slot="context-menu-group" {...props} />;
}

export default ContextMenuGroup;
