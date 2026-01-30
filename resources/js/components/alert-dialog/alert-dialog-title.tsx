import { AlertDialog } from "@base-ui/react/alert-dialog";
import { cn } from "@narsil-cms/lib/utils";

function AlertDialogTitle({ className, ...props }: AlertDialog.Title.Props) {
  return (
    <AlertDialog.Title
      data-slot="alert-dialog-title"
      className={cn(
        "text-base font-medium",
        "sm:group-data-[size=default]/alert-dialog-popup:group-has-data-[slot=alert-dialog-media]/alert-dialog-popup:col-start-2",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogTitle;
