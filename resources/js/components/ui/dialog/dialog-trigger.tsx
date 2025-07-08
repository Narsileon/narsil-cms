import { Dialog as DialogPrimitive } from "radix-ui";

type DialogTriggerProps = React.ComponentProps<
  typeof DialogPrimitive.Trigger
> & {};

function DialogTrigger({ ...props }: DialogTriggerProps) {
  return <DialogPrimitive.Trigger data-slot="dialog-trigger" {...props} />;
}
export default DialogTrigger;
