import * as React from "react";
import { AlertDialog as AlertDialogPrimitive } from "radix-ui";

type AlertDialogPortalProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Portal
> & {};

function AlertDialogPortal({ ...props }: AlertDialogPortalProps) {
  return (
    <AlertDialogPrimitive.Portal data-slot="alert-dialog-portal" {...props} />
  );
}

export default AlertDialogPortal;
