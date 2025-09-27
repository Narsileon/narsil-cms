import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AlertDialogContentProps = ComponentProps<typeof AlertDialog.Content> & {};

function AlertDialogContent({ className, ...props }: AlertDialogContentProps) {
  return (
    <AlertDialog.Content
      data-slot="alert-dialog-content"
      className={cn(
        "fixed top-[50%] left-[50%] grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] gap-4 rounded-md border bg-background p-4 shadow-lg duration-300 not-first:z-50 sm:max-w-lg",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogContent;
