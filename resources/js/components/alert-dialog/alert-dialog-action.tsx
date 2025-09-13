import { AlertDialog } from "radix-ui";

import { buttonVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogActionProps = React.ComponentProps<
  typeof AlertDialog.Action
> & {};

function AlertDialogAction({ className, ...props }: AlertDialogActionProps) {
  return (
    <AlertDialog.Action
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
