import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function AlertDialogFooter({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="alert-dialog-footer"
      className={cn(
        "-mx-4 -mb-4 flex flex-col-reverse gap-2 rounded-b-xl border-t bg-muted/50 p-4 sm:flex-row sm:justify-end",
        "group-data-[size=sm]/alert-dialog-popup:grid",
        "group-data-[size=sm]/alert-dialog-popup:grid-cols-2",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogFooter;
