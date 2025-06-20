import { cn } from "@/components";
import { Overlay } from "@radix-ui/react-alert-dialog";

export type AlertDialogOverlayProps = React.ComponentProps<typeof Overlay> & {};

function AlertDialogOverlay({ className, ...props }: AlertDialogOverlayProps) {
  return (
    <Overlay
      data-slot="alert-dialog-overlay"
      className={cn(
        "fixed inset-0 z-50 bg-black/50",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "data-[state=open]:fade-in-0 data-[state=closed]:fade-out-0",
        className,
      )}
      {...props}
    />
  );
}

export default AlertDialogOverlay;
