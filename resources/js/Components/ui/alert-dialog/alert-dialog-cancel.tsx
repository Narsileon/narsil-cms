import { buttonVariants } from "@/Components/ui/button";
import { cn } from "@/Components";
import { Cancel } from "@radix-ui/react-alert-dialog";

export type AlertDialogCancelProps = React.ComponentProps<typeof Cancel> & {};

function AlertDialogCancel({ className, ...props }: AlertDialogCancelProps) {
  return (
    <Cancel
      className={cn(
        buttonVariants({
          variant: "outline",
        }),
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogCancel;
