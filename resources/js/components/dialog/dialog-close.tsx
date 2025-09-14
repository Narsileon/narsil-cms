import { Dialog } from "radix-ui";

type DialogCloseProps = React.ComponentProps<typeof Dialog.Close> & {};

function DialogClose({ ...props }: DialogCloseProps) {
  return <Dialog.Close data-slot="dialog-close" {...props} />;
}

export default DialogClose;
