import { AlertDialog as AlertDialogPrimitive } from "radix-ui";
import { cn } from "@/components";

export type AlertDialogTitleProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Title
> & {};

function AlertDialogTitle({ className, ...props }: AlertDialogTitleProps) {
  return (
    <AlertDialogPrimitive.Title
      data-slot="alert-dialog-title"
      className={cn("text-lg font-semibold", className)}
      {...props}
    />
  );
}

export default AlertDialogTitle;
