import { Dialog } from "@base-ui/react/dialog";
import { cn } from "@narsil-cms/lib/utils";

function DialogBackdrop({ className, ...props }: Dialog.Backdrop.Props) {
  return (
    <Dialog.Backdrop
      data-slot="dialog-backdrop"
      className={cn(
        "fixed inset-0 isolate z-50 bg-black/10 duration-100",
        "data-closed:animate-out data-closed:fade-out-0",
        "data-open:animate-in data-open:fade-in-0",
        "supports-backdrop-filter:backdrop-blur-xs",
        className,
      )}
      {...props}
    />
  );
}

export default DialogBackdrop;
