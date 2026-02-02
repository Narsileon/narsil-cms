import { Dialog } from "@base-ui/react/dialog";
import { Backdrop } from "@narsil-cms/components/backdrop";

function DialogBackdrop({ className, ...props }: Dialog.Backdrop.Props) {
  return <Dialog.Backdrop data-slot="dialog-backdrop" render={<Backdrop />} {...props} />;
}

export default DialogBackdrop;
