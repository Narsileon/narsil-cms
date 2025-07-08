import { AlertDialog as AlertDialogPrimitive } from "radix-ui";

type AlertDialogProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Root
> & {};

function AlertDialog({ ...props }: AlertDialogProps) {
  return <AlertDialogPrimitive.Root data-slot="alert-dialog" {...props} />;
}

export default AlertDialog;
