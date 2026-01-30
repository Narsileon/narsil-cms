import { AlertDialog } from "@base-ui/react/alert-dialog";

function AlertDialogPortal({ ...props }: AlertDialog.Portal.Props) {
  return <AlertDialog.Portal data-slot="alert-dialog-portal" {...props} />;
}

export default AlertDialogPortal;
