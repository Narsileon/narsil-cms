import { Dialog } from "@base-ui/react/dialog";

function DialogRoot({ ...props }: Dialog.Root.Props) {
  return <Dialog.Root data-slot="dialog-root" {...props} />;
}

export default DialogRoot;
