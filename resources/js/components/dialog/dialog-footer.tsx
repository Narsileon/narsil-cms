import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type DialogFooterProps = ComponentProps<"div">;

function DialogFooter({ className, ...props }: DialogFooterProps) {
  return (
    <div
      data-slot="dialog-footer"
      className={cn(
        "flex h-13 flex-col-reverse gap-2 px-4 pb-2 sm:flex-row sm:justify-end [.border-t]:pt-2",
        className,
      )}
      {...props}
    />
  );
}

export default DialogFooter;
