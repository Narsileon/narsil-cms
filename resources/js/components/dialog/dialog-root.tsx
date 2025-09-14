import { Dialog } from "radix-ui";

type DialogRootProps = React.ComponentProps<typeof Dialog.Root> & {};

function DialogRoot({ ...props }: DialogRootProps) {
  return <Dialog.Root data-slot="dialog-root" {...props} />;
}

export default DialogRoot;
