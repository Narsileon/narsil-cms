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
      data-slot="alert-dialog-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default AlertDialogDescription;
