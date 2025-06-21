import { AlertDialog as AlertDialogPrimitive } from "radix-ui";
import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/components";

export type AlertDialogActionProps = React.ComponentProps<
  typeof AlertDialogPrimitive.Action
> & {};

function AlertDialogAction({ className, ...props }: AlertDialogActionProps) {
  return (
    <AlertDialogPrimitive.Action
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
