import { type VariantProps } from "class-variance-authority";
import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

import { VisuallyHidden } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";

import DialogCloseButton from "./dialog-close-button";
import dialogContentVariants from "./dialog-content-variants";
import DialogOverlay from "./dialog-overlay";
import DialogPortal from "./dialog-portal";

type DialogContentProps = ComponentProps<typeof Dialog.Content> &
  VariantProps<typeof dialogContentVariants> &
  Pick<ComponentProps<typeof DialogPortal>, "container"> & {
    showCloseButton?: boolean;
  };

function DialogContent({
  className,
  children,
  container,
  showCloseButton = true,
  variant = "default",
  ...props
}: DialogContentProps) {
  return (
    <DialogPortal container={container}>
      <DialogOverlay />
      <Dialog.Content
        data-slot="dialog-content"
        className={cn(
          dialogContentVariants({
            className: className,
            variant: variant,
          }),
        )}
        {...props}
      >
        <VisuallyHidden tabIndex={0}>Dialog</VisuallyHidden>
        {children}
        {showCloseButton ? (
          <DialogCloseButton className="absolute right-4 top-4" />
        ) : null}
      </Dialog.Content>
    </DialogPortal>
  );
}

export default DialogContent;
