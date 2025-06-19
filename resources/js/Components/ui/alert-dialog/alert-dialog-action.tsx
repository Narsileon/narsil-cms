import { Action } from "@radix-ui/react-alert-dialog";
import { buttonVariants } from "@/Components/ui/button";
import { cn } from "@/Components";

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
