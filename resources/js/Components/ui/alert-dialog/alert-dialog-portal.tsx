import { Portal } from "@radix-ui/react-alert-dialog";

export type AlertDialogPortalProps = React.ComponentProps<typeof Portal> & {};

function AlertDialogPortal({ ...props }: AlertDialogPortalProps) {
  return <Portal data-slot="alert-dialog-portal" {...props} />;
}

export default AlertDialogPortal;
