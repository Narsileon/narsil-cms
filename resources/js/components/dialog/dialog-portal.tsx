import { Dialog } from "radix-ui";

type DialogPortalProps = React.ComponentProps<typeof Dialog.Portal> & {};

function DialogPortal({ ...props }: DialogPortalProps) {
  return <Dialog.Portal data-slot="dialog-portal" {...props} />;
}

export default DialogPortal;
