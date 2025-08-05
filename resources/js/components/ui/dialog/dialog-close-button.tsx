import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";
import { Icon } from "@narsil-cms/components/ui/icon";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";

type DialogCloseButtonProps = React.ComponentProps<
  typeof DialogPrimitive.Close
> & {};

function DialogCloseButton({ className, ...props }: DialogCloseButtonProps) {
  const { getLabel } = useLabels();

  return (
    <DialogPrimitive.Close
      data-slot="dialog-close"
      className={cn(
        "ring-offset-background rounded-full opacity-75 transition-opacity",
        "disabled:pointer-events-none",
        "focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:outline-hidden",
        "hover:opacity-100",
        "data-[state=open]:bg-accent data-[state=open]:text-muted-foreground",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      <Icon name="x" />
      <VisuallyHidden>
        {getLabel("accessibility.close_dialog", "Close dialog")}
      </VisuallyHidden>
    </DialogPrimitive.Close>
  );
}

export default DialogCloseButton;
