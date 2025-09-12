import { cn } from "@narsil-cms/lib/utils";

type DialogFooterProps = React.ComponentProps<"div"> & {};

function DialogFooter({ className, ...props }: DialogFooterProps) {
  return (
    <div
      data-slot="dialog-footer"
      className={cn(
        "flex flex-col-reverse gap-3 px-5 pb-3 sm:flex-row sm:justify-end [.border-t]:pt-3",
        className,
      )}
      {...props}
    />
  );
}

export default DialogFooter;
