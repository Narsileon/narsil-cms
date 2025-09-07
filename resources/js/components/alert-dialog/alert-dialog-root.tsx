import * as React from "react";
import { AlertDialog as AlertDialogPrimitive } from "radix-ui";

type AlertDialogRootProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Root
> & {};

function AlertDialogRoot({ ...props }: AlertDialogRootProps) {
  return <AlertDialogPrimitive.Root data-slot="alert-dialog-root" {...props} />;
}

export default AlertDialogRoot;
