import { cn } from "@/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";

export type DialogOverlayProps = React.ComponentProps<
  typeof DialogPrimitive.Overlay
> & {};

function DialogOverlay({ className, ...props }: DialogOverlayProps) {
  return (
    <DialogPrimitive.Overlay
      data-slot="dialog-overlay"
      className={cn(
        "fixed inset-0 z-50 bg-black/50",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        className,
      )}
      {...props}
    />
  );
}

export default DialogOverlay;
