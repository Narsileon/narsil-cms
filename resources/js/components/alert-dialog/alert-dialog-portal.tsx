import { AlertDialog } from "radix-ui";

type AlertDialogPortalProps = React.ComponentProps<
  typeof AlertDialog.Portal
> & {};

function AlertDialogPortal({ ...props }: AlertDialogPortalProps) {
  return <AlertDialog.Portal data-slot="alert-dialog-portal" {...props} />;
}

export default AlertDialogPortal;
