import { AlertDialog as AlertDialogPrimitive } from "radix-ui";

import { buttonVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogCancelProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Cancel
> & {};

function AlertDialogCancel({ className, ...props }: AlertDialogCancelProps) {
  return (
    <AlertDialogPrimitive.Cancel
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
