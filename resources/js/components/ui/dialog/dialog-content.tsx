import { cn } from "@/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";
import DialogOverlay from "./dialog-overlay";
import DialogPortal from "./dialog-portal";
import DialogCloseButton from "./dialog-close-button";

export type DialogContentProps = React.ComponentPropsWithoutRef<
  typeof DialogPrimitive.Content
> & {
  showCloseButton?: boolean;
};

function DialogContent({
  className,
  children,
  showCloseButton = true,
  ...props
}: DialogContentProps) {
  return (
    <DialogPortal data-slot="dialog-portal">
      <DialogOverlay />
      <DialogPrimitive.Content
        data-slot="dialog-content"
        className={cn(
          "bg-background fixed top-[50%] left-[50%] z-50 grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] gap-6 overflow-hidden rounded-lg border p-6 shadow-lg duration-200 md:max-w-lg",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          className,
        )}
        {...props}
      >
        {children}
        {showCloseButton ? (
          <DialogCloseButton className="absolute top-4 right-4" />
        ) : null}
      </DialogPrimitive.Content>
    </DialogPortal>
  );
}

export default DialogContent;
