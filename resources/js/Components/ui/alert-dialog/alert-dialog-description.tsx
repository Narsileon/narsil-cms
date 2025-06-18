import { cn } from "@/Components";
import { Description } from "@radix-ui/react-alert-dialog";

export type AlertDialogDescriptionProps = React.ComponentProps<
  typeof Description
> & {};

function AlertDialogDescription({
  className,
  ...props
}: AlertDialogDescriptionProps) {
  return (
    <Description
      className={cn("text-muted-foreground text-sm", className)}
      data-slot="alert-dialog-description"
      {...props}
    />
  );
}

export default AlertDialogDescription;
