import { Sub } from "@radix-ui/react-context-menu";

export type ContextMenuSubProps = React.ComponentProps<typeof Sub> & {};

function ContextMenuSub({ ...props }: ContextMenuSubProps) {
  return <Sub data-slot="context-menu-sub" {...props} />;
}

export default ContextMenuSub;
