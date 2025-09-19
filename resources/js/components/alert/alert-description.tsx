import { cn } from "@narsil-cms/lib/utils";

type AlertDescriptionProps = React.ComponentProps<"div"> & {};

function AlertDescription({ className, ...props }: AlertDescriptionProps) {
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
