import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function AlertDialogHeader({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="alert-dialog-header"
      className={cn(
        "grid grid-rows-[auto_1fr] place-items-center gap-1.5 text-center",
        "has-data-[slot=alert-dialog-media]:grid-rows-[auto_auto_1fr]",
        "has-data-[slot=alert-dialog-media]:gap-x-4",
        "sm:group-data-[size=default]/alert-dialog-popup:place-items-start",
        "sm:group-data-[size=default]/alert-dialog-popup:text-left",
        "sm:group-data-[size=default]/alert-dialog-popup:has-data-[slot=alert-dialog-media]:grid-rows-[auto_1fr]",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogHeader;
