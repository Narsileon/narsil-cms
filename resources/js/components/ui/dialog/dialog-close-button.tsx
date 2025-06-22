import { Dialog as DialogPrimitive } from "radix-ui";
import { XIcon } from "lucide-react";
import { cn } from "@/lib/utils";

export type DialogCloseButtonProps = React.ComponentProps<
  typeof DialogPrimitive.Close
> & {};

function DialogCloseButton({ className, ...props }: DialogCloseButtonProps) {
  return (
    <DialogPrimitive.Close
      data-slot="dialog-close"
      className={cn(
        "ring-offset-background rounded-xs opacity-70 transition-opacity",
        "disabled:pointer-events-none",
        "focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:outline-hidden",
        "hover:opacity-100",
        "data-[state=open]:bg-accent data-[state=open]:text-muted-foreground",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      <XIcon />
      <span className="sr-only">Close</span>
    </DialogPrimitive.Close>
  );
}

export default DialogCloseButton;
