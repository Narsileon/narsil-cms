import { Dialog } from "@base-ui/react/dialog";

function DialogClose({ ...props }: Dialog.Close.Props) {
  return <Dialog.Close data-slot="dialog-close" {...props} />;
}

export default DialogClose;
