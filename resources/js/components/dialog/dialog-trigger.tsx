import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

type DialogTriggerProps = ComponentProps<typeof Dialog.Trigger>;

function DialogTrigger({ ...props }: DialogTriggerProps) {
  return <Dialog.Trigger data-slot="dialog-trigger" {...props} />;
}
export default DialogTrigger;
