import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

type AlertDialogRootProps = ComponentProps<typeof AlertDialog.Root>;

function AlertDialogRoot({ ...props }: AlertDialogRootProps) {
  return <AlertDialog.Root data-slot="alert-dialog-root" {...props} />;
}

export default AlertDialogRoot;
