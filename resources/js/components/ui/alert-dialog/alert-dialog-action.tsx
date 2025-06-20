import { Action } from "@radix-ui/react-alert-dialog";
import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/components";

export type AlertDialogActionProps = React.ComponentProps<typeof Action> & {};

function AlertDialogAction({ className, ...props }: AlertDialogActionProps) {
  return (
    <Action
      className={cn(
        buttonVariants({
          variant: "default",
        }),
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogAction;
