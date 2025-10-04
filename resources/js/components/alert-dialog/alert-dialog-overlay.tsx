import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AlertDialogOverlayProps = ComponentProps<typeof AlertDialog.Overlay>;

function AlertDialogOverlay({ className, ...props }: AlertDialogOverlayProps) {
  return (
    <AlertDialog.Overlay
      data-slot="alert-dialog-overlay"
      className={cn(
        "fixed inset-0 z-50 bg-black/50",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogOverlay;
