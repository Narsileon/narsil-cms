import { Close } from "@radix-ui/react-dialog";

export type DialogCloseProps = React.ComponentProps<typeof Close> & {};

function DialogClose({ ...props }: DialogCloseProps) {
  return <Close data-slot="dialog-close" {...props} />;
}

export default DialogClose;
