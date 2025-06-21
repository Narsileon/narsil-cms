import { AlertDialog as AlertDialogPrimitive } from "radix-ui";
import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/lib/utils";

export type AlertDialogCancelProps = React.ComponentProps<
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
