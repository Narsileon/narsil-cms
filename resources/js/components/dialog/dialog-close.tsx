import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

type DialogCloseProps = ComponentProps<typeof Dialog.Close> & {};

function DialogClose({ ...props }: DialogCloseProps) {
  return <Dialog.Close data-slot="dialog-close" {...props} />;
}

export default DialogClose;
