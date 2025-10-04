import { AlertDialog } from "radix-ui";
import { type ComponentProps } from "react";

import { buttonRootVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";

type AlertDialogActionProps = ComponentProps<typeof AlertDialog.Action>;

function AlertDialogAction({ className, ...props }: AlertDialogActionProps) {
  return (
    <AlertDialog.Action
      className={cn(
        buttonRootVariants({
          className: className,
          variant: "default",
        }),
      )}
      {...props}
    />
  );
}

export default AlertDialogAction;
