import { buttonVariants } from "@/Components/ui/button";
import { cn } from "@/Components";
import { Action } from "@radix-ui/react-alert-dialog";

export type AlertDialogActionProps = React.ComponentProps<typeof Action> & {};

function AlertDialogAction({ className, ...props }: AlertDialogActionProps) {
  return <Action className={cn(buttonVariants(), className)} {...props} />;
}

export default AlertDialogAction;
