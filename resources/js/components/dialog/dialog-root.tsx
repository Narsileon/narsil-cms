import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

type DialogRootProps = ComponentProps<typeof Dialog.Root> & {};

function DialogRoot({ ...props }: DialogRootProps) {
  return <Dialog.Root data-slot="dialog-root" {...props} />;
}

export default DialogRoot;
