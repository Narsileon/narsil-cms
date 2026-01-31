import { Dialog } from "@base-ui/react/dialog";

function DialogPortal({ ...props }: Dialog.Portal.Props) {
  return <Dialog.Portal data-slot="dialog-portal" {...props} />;
}

export default DialogPortal;
