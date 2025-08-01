import { AlertDialog as AlertDialogPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogDescriptionProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Description
> & {};

function AlertDialogDescription({
  className,
  ...props
}: AlertDialogDescriptionProps) {
  return (
    <AlertDialogPrimitive.Description
      data-slot="alert-dialog-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default AlertDialogDescription;
