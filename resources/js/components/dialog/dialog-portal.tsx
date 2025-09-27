import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

type DialogPortalProps = ComponentProps<typeof Dialog.Portal> & {};

function DialogPortal({ ...props }: DialogPortalProps) {
  return <Dialog.Portal data-slot="dialog-portal" {...props} />;
}

export default DialogPortal;
