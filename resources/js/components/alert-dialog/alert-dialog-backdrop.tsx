import { AlertDialog } from "@base-ui/react/alert-dialog";
import { Backdrop } from "@narsil-cms/components/backdrop";

function AlertDialogBackdrop({ className, ...props }: AlertDialog.Backdrop.Props) {
  return (
    <AlertDialog.Backdrop data-slot="alert-dialog-backdrop" render={<Backdrop />} {...props} />
  );
}

export default AlertDialogBackdrop;
