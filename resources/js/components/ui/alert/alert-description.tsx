import { cn } from "@/lib/utils";

export type AlertDescriptionProps = React.ComponentProps<"div"> & {};

function AlertDescription({ className, ...props }: AlertDescriptionProps) {
  return (
    <div
      data-slot="alert-description"
      className={cn(
        "text-muted-foreground col-start-2 grid justify-items-start gap-1 text-sm",
        "[&_p]:leading-relaxed",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDescription;
