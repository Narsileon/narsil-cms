import { Dialog } from "@base-ui/react/dialog";

function DialogTrigger({ ...props }: Dialog.Trigger.Props) {
  return <Dialog.Trigger data-slot="dialog-trigger" {...props} />;
}
export default DialogTrigger;
