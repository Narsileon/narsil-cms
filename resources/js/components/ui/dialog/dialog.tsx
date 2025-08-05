import * as React from "react";
import { Dialog as DialogPrimitive } from "radix-ui";

type DialogProps = React.ComponentProps<typeof DialogPrimitive.Root> & {};

function Dialog({ ...props }: DialogProps) {
  return <DialogPrimitive.Root data-slot="dialog" {...props} />;
}

export default Dialog;
