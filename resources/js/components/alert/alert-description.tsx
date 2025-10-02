import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AlertDescriptionProps = ComponentProps<"div"> & {};

function AlertDescription({ className, ...props }: AlertDescriptionProps) {
  return (
    <div
      data-slot="alert-description"
      className={cn(
        "text-muted-foreground col-start-2 grid justify-items-start gap-1",
        "[&_p]:leading-relaxed",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDescription;
