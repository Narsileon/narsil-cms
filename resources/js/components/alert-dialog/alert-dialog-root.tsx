import { AlertDialog } from "radix-ui";

type AlertDialogRootProps = React.ComponentProps<typeof AlertDialog.Root> & {};

function AlertDialogRoot({ ...props }: AlertDialogRootProps) {
  return <AlertDialog.Root data-slot="alert-dialog-root" {...props} />;
}

export default AlertDialogRoot;
