import { Dialog } from "@base-ui/react/dialog";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import DialogCloseButton from "./dialog-close-button";
import dialogPopupVariants from "./dialog-popup-variants";

function DialogPopup({
  className,
  children,
  showCloseButton = true,
  variant = "default",
  ...props
}: ComponentProps<typeof Dialog.Popup> &
  VariantProps<typeof dialogPopupVariants> & {
    showCloseButton?: boolean;
  }) {
  return (
    <Dialog.Popup
      data-slot="dialog-popup"
      className={cn(
        dialogPopupVariants({
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
    </Dialog.Popup>
  );
}

export default DialogPopup;
