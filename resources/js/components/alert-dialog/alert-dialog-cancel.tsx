import { AlertDialog } from "radix-ui";

import { buttonVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogCancelProps = React.ComponentProps<
  typeof AlertDialog.Cancel
> & {};

function AlertDialogCancel({ className, ...props }: AlertDialogCancelProps) {
  return (
    <AlertDialog.Cancel
      className={cn(
        buttonVariants({
          variant: "outline",
        }),
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogCancel;
