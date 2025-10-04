import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogDescriptionProps = ComponentProps<typeof Dialog.Description>;

function DialogDescription({ className, ...props }: DialogDescriptionProps) {
  return (
    <Dialog.Description
      data-slot="dialog-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default DialogDescription;
