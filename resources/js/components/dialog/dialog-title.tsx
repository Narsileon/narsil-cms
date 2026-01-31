import { Dialog } from "@base-ui/react/dialog";
import { cn } from "@narsil-cms/lib/utils";

function DialogTitle({ className, ...props }: Dialog.Title.Props) {
  return (
    <Dialog.Title
      data-slot="dialog-title"
      className={cn("text-base leading-none font-medium", className)}
      {...props}
    />
  );
}

export default DialogTitle;
