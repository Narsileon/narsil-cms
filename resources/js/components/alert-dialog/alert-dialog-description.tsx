import { AlertDialog } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AlertDialogDescriptionProps = React.ComponentProps<
  typeof AlertDialog.Description
> & {};

function AlertDialogDescription({
  className,
  ...props
}: AlertDialogDescriptionProps) {
  return (
    <AlertDialog.Description
      data-slot="alert-dialog-description"
      className={cn("text-sm text-muted-foreground", className)}
      {...props}
    />
  );
}

export default AlertDialogDescription;
