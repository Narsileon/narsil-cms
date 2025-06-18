import { cn } from "@/Components";

export type AlertDialogHeaderProps = React.ComponentProps<"div"> & {};

function AlertDialogHeader({ className, ...props }: AlertDialogHeaderProps) {
  return (
    <div
      className={cn("flex flex-col gap-2 text-center sm:text-left", className)}
      data-slot="alert-dialog-header"
      {...props}
    />
  );
}

export default AlertDialogHeader;
