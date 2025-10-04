import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogOverlayProps = ComponentProps<typeof Dialog.Overlay>;

function DialogOverlay({ className, ...props }: DialogOverlayProps) {
  return (
    <Dialog.Overlay
      data-slot="dialog-overlay"
      className={cn(
        "fixed inset-0 z-50 bg-black/50",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        className,
      )}
      {...props}
    />
  );
}

export default DialogOverlay;
