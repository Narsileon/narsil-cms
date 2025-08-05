import * as React from "react";
import { AlertDialog as AlertDialogPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";
import AlertDialogPortal from "./alert-dialog-portal";
import AlertDialogOverlay from "./alert-dialog-overlay";

type AlertDialogContentProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Content
> & {};

function AlertDialogContent({ className, ...props }: AlertDialogContentProps) {
  return (
    <AlertDialogPortal>
      <AlertDialogOverlay />
      <AlertDialogPrimitive.Content
        data-slot="alert-dialog-content"
        className={cn(
          "bg-background left-[50%]z-50 fixed top-[50%] grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] gap-4 rounded-md border p-4 shadow-lg duration-200 sm:max-w-lg",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          className,
        )}
        {...props}
      />
    </AlertDialogPortal>
  );
}

export default AlertDialogContent;
