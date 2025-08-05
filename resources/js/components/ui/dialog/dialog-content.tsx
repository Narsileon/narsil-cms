import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";
import DialogOverlay from "./dialog-overlay";
import DialogPortal from "./dialog-portal";
import DialogCloseButton from "./dialog-close-button";

type DialogContentProps = React.ComponentProps<typeof DialogPrimitive.Content> &
  Pick<React.ComponentProps<typeof DialogPortal>, "container"> & {
    showCloseButton?: boolean;
  };

function DialogContent({
  className,
  children,
  container,
  showCloseButton = true,
  ...props
}: DialogContentProps) {
  return (
    <DialogPortal data-slot="dialog-portal" container={container}>
      <DialogOverlay />
      <DialogPrimitive.Content
        data-slot="dialog-content"
        className={cn(
          "@container/dialog-content",
          "bg-background fixed top-[50%] left-[50%] z-50 flex w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] flex-col overflow-hidden rounded-md border shadow-lg duration-200 md:max-w-lg",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          className,
        )}
        {...props}
      >
        {children}
        {showCloseButton ? (
          <DialogCloseButton className="absolute top-5.5 right-5.5" />
        ) : null}
      </DialogPrimitive.Content>
    </DialogPortal>
  );
}

export default DialogContent;
