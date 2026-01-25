import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type AlertDialogFooterProps = ComponentProps<"div">;

function AlertDialogFooter({ className, ...props }: AlertDialogFooterProps) {
  return (
    <div
      data-slot="alert-dialog-footer"
      className={cn("flex flex-col-reverse gap-2 sm:flex-row sm:justify-between", className)}
      {...props}
    />
  );
}

export default AlertDialogFooter;
