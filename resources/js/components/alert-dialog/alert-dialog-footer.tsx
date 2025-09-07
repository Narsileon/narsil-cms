import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogFooterProps = React.ComponentProps<"div"> & {};

function AlertDialogFooter({ className, ...props }: AlertDialogFooterProps) {
  return (
    <div
      data-slot="alert-dialog-footer"
      className={cn(
        "flex flex-col-reverse gap-2 sm:flex-row sm:justify-end",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogFooter;
