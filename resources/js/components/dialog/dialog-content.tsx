import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";
import DialogCloseButton from "./dialog-close-button";
import dialogContentVariants from "./dialog-content-variants";

function DialogContent({
  className,
  children,
  showCloseButton = true,
  variant = "default",
  ...props
}: ComponentProps<typeof Dialog.Content> &
  VariantProps<typeof dialogContentVariants> & {
    showCloseButton?: boolean;
  }) {
  return (
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
      <span className="sr-only" tabIndex={0}>
        Dialog
      </span>
      {children}
      {showCloseButton ? <DialogCloseButton className="absolute top-4 right-4" /> : null}
    </Dialog.Content>
  );
}

export default DialogContent;
