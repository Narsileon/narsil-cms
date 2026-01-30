import { AlertDialog } from "@base-ui/react/alert-dialog";
import { cn } from "@narsil-cms/lib/utils";

function AlertDialogBackdrop({ className, ...props }: AlertDialog.Backdrop.Props) {
  return (
    <AlertDialog.Backdrop
      data-slot="alert-dialog-backdrop"
      className={cn(
        "fixed inset-0 isolate z-50 bg-black/10 duration-100",
        "data-closed:animate-out data-closed:fade-out-0",
        "data-open:animate-in data-open:fade-in-0",
        "supports-backdrop-filter:backdrop-blur-xs",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogBackdrop;
