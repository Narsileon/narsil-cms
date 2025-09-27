import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";
type AlertTitleProps = ComponentProps<"div"> & {};

function AlertTitle({ className, ...props }: AlertTitleProps) {
  return (
    <div
      data-slot="alert-title"
      className={cn(
        "col-start-2 line-clamp-1 min-h-4 font-medium tracking-tight",
        className,
      )}
      {...props}
    />
  );
}

export default AlertTitle;
