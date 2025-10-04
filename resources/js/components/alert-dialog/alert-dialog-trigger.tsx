import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

type AlertDialogTriggerProps = ComponentProps<typeof AlertDialog.Trigger>;

function AlertDialogTrigger({ ...props }: AlertDialogTriggerProps) {
  return <AlertDialog.Trigger data-slot="alert-dialog-trigger" {...props} />;
}

export default AlertDialogTrigger;
