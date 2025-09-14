import { Dialog } from "radix-ui";

type DialogTriggerProps = React.ComponentProps<typeof Dialog.Trigger> & {};

function DialogTrigger({ ...props }: DialogTriggerProps) {
  return <Dialog.Trigger data-slot="dialog-trigger" {...props} />;
}
export default DialogTrigger;
