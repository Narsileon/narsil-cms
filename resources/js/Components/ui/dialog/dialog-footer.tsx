import { cn } from "@/Components";

export type DialogFooterProps = React.ComponentProps<"div"> & {};

function DialogFooter({ className, ...props }: DialogFooterProps) {
  return (
    <div
      data-slot="dialog-footer"
      className={cn(
        "flex flex-col-reverse gap-2 sm:flex-row sm:justify-end",
        className,
      )}
      {...props}
    />
  );
}

export default DialogFooter;
