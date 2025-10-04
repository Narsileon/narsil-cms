import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AlertDialogDescriptionProps = ComponentProps<
  typeof AlertDialog.Description
>;

function AlertDialogDescription({
  className,
  ...props
}: AlertDialogDescriptionProps) {
  return (
    <AlertDialog.Description
      data-slot="alert-dialog-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default AlertDialogDescription;
