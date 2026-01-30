import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function AlertDescription({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="alert-description"
      className={cn(
        "col-start-2 grid justify-items-start gap-1 text-muted-foreground",
        "[&_p]:leading-relaxed",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDescription;
