import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogFooterProps = ComponentProps<"div">;

function DialogFooter({ className, ...props }: DialogFooterProps) {
  return (
    <div
      data-slot="dialog-footer"
      className={cn(
        "[.border-t]:pt-2 h-13 flex flex-col-reverse gap-2 px-4 pb-2 sm:flex-row sm:justify-end",
        className,
      )}
      {...props}
    />
  );
}

export default DialogFooter;
