import { AlertDialog } from "@base-ui/react/alert-dialog";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogPopupProps = AlertDialog.Popup.Props & { size?: "default" | "sm" };

function AlertDialogPopup({ className, size = "default", ...props }: AlertDialogPopupProps) {
  return (
    <AlertDialog.Popup
      data-slot="alert-dialog-popup"
      data-size={size}
      className={cn(
        "group/alert-dialog-popup",
        "fixed top-1/2 left-1/2 z-50 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 rounded-xl bg-background p-4 ring-1 ring-foreground/10 duration-100 outline-none",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        size === "default" && "max-w-xs sm:max-w-sm",
        size === "sm" && "max-w-xs",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogPopup;
