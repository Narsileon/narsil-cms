import { AlertDialog } from "radix-ui";

type AlertDialogTriggerProps = React.ComponentProps<
  typeof AlertDialog.Trigger
> & {};

function AlertDialogTrigger({ ...props }: AlertDialogTriggerProps) {
  return <AlertDialog.Trigger data-slot="alert-dialog-trigger" {...props} />;
}

export default AlertDialogTrigger;
