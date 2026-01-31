import { AlertDialog } from "@base-ui/react/alert-dialog";
import { cn } from "@narsil-cms/lib/utils";

function AlertDialogDescription({ className, ...props }: AlertDialog.Description.Props) {
  return (
    <AlertDialog.Description
      data-slot="alert-dialog-description"
      className={cn(
        "text-sm text-balance text-muted-foreground md:text-pretty",
        "*:[a]:underline *:[a]:underline-offset-3 *:[a]:hover:text-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogDescription;
