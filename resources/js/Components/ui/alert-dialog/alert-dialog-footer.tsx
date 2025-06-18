import { cn } from "@/Components";

export type AlertDialogFooterProps = React.ComponentProps<"div"> & {};

function AlertDialogFooter({ className, ...props }: AlertDialogFooterProps) {
  return (
    <div
      className={cn(
        "flex flex-col-reverse gap-2 sm:flex-row sm:justify-end",
        className,
      )}
      data-slot="alert-dialog-footer"
      {...props}
    />
  );
}

export default AlertDialogFooter;
