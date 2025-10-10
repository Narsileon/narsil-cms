import { buttonRootVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

type AlertDialogCancelProps = ComponentProps<typeof AlertDialog.Cancel>;

function AlertDialogCancel({ className, ...props }: AlertDialogCancelProps) {
  return (
    <AlertDialog.Cancel
      className={cn(
        buttonRootVariants({
          className: className,
          variant: "outline",
        }),
      )}
      {...props}
    />
  );
}

export default AlertDialogCancel;
