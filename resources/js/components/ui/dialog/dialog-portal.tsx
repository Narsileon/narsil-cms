import { Portal } from "@radix-ui/react-dialog";

export type DialogPortalProps = React.ComponentProps<typeof Portal> & {};

function DialogPortal({ ...props }: DialogPortalProps) {
  return <Portal data-slot="dialog-portal" {...props} />;
}

export default DialogPortal;
