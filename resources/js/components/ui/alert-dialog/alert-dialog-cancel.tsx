import { buttonVariants } from "@/components/ui/button";
import { Cancel } from "@radix-ui/react-alert-dialog";
import { cn } from "@/components";

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
