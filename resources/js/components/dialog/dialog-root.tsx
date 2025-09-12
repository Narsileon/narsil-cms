import { Dialog as DialogPrimitive } from "radix-ui";

type DialogRootProps = React.ComponentProps<typeof DialogPrimitive.Root> & {};

function DialogRoot({ ...props }: DialogRootProps) {
  return <DialogPrimitive.Root data-slot="dialog-root" {...props} />;
}

export default DialogRoot;
