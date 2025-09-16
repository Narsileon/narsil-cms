import { type VariantProps } from "class-variance-authority";
import { Dialog } from "radix-ui";

import { VisuallyHidden } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";

import DialogCloseButton from "./dialog-close-button";
import dialogContentVariants from "./dialog-content-variants";
import DialogOverlay from "./dialog-overlay";
import DialogPortal from "./dialog-portal";

type DialogContentProps = React.ComponentProps<typeof Dialog.Content> &
  VariantProps<typeof dialogContentVariants> &
  Pick<React.ComponentProps<typeof DialogPortal>, "container"> & {
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
        <VisuallyHidden aria-hidden="true" tabIndex={0}>
          Dialog
        </VisuallyHidden>
        {children}
        {showCloseButton ? (
          <DialogCloseButton className="absolute top-5.5 right-5.5" />
        ) : null}
      </Dialog.Content>
    </DialogPortal>
  );
}

export default DialogContent;
