import { AlertDialog } from "@base-ui/react/alert-dialog";

function AlertDialogTrigger({ ...props }: AlertDialog.Trigger.Props) {
  return <AlertDialog.Trigger data-slot="alert-dialog-trigger" {...props} />;
}

export default AlertDialogTrigger;
