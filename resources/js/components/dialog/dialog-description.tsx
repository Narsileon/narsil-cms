import { Dialog as DialogPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DialogDescriptionProps = React.ComponentProps<
  typeof DialogPrimitive.Description
> & {};

function DialogDescription({ className, ...props }: DialogDescriptionProps) {
  return (
    <DialogPrimitive.Description
      data-slot="dialog-description"
      className={cn("text-sm text-muted-foreground", className)}
      {...props}
    />
  );
}

export default DialogDescription;
