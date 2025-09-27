import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

type AlertDialogPortalProps = ComponentProps<typeof AlertDialog.Portal> & {};

function AlertDialogPortal({ ...props }: AlertDialogPortalProps) {
  return <AlertDialog.Portal data-slot="alert-dialog-portal" {...props} />;
}

export default AlertDialogPortal;
