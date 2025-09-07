import * as React from "react";
import { Dialog as DialogPrimitive } from "radix-ui";

type DialogPortalProps = React.ComponentProps<
  typeof DialogPrimitive.Portal
> & {};

function DialogPortal({ ...props }: DialogPortalProps) {
  return <DialogPrimitive.Portal data-slot="dialog-portal" {...props} />;
}

export default DialogPortal;
