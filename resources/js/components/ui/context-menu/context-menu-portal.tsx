import { Portal } from "@radix-ui/react-context-menu";

export type ContextMenuPortalProps = React.ComponentProps<typeof Portal> & {};

function ContextMenuPortal({ ...props }: ContextMenuPortalProps) {
  return <Portal data-slot="context-menu-portal" {...props} />;
}

export default ContextMenuPortal;
