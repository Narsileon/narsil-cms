import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function AlertDialogMedia({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="alert-dialog-media"
      className={cn(
        "mb-2 inline-flex size-10 items-center justify-center rounded-md bg-muted",
        "sm:group-data-[size=default]/alert-dialog-popup:row-span-2",
        "*:[svg:not([class*='size-'])]:size-6",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogMedia;
