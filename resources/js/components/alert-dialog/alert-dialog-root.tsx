import { AlertDialog } from "@base-ui/react/alert-dialog";

function AlertDialogRoot({ ...props }: AlertDialog.Root.Props) {
  return <AlertDialog.Root data-slot="alert-dialog-root" {...props} />;
}

export default AlertDialogRoot;
