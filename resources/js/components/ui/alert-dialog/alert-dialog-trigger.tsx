import { AlertDialog as AlertDialogPrimitive } from "radix-ui";

type AlertDialogTriggerProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Trigger
> & {};

function AlertDialogTrigger({ ...props }: AlertDialogTriggerProps) {
  return (
    <AlertDialogPrimitive.Trigger data-slot="alert-dialog-trigger" {...props} />
  );
}

export default AlertDialogTrigger;
