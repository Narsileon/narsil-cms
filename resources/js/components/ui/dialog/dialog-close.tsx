import * as React from "react";
import { Dialog as DialogPrimitive } from "radix-ui";

type DialogCloseProps = React.ComponentProps<typeof DialogPrimitive.Close> & {};

function DialogClose({ ...props }: DialogCloseProps) {
  return <DialogPrimitive.Close data-slot="dialog-close" {...props} />;
}

export default DialogClose;
