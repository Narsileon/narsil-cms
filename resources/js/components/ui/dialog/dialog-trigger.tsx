import { Trigger } from "@radix-ui/react-dialog";

export type DialogTriggerProps = React.ComponentProps<typeof Trigger> & {};

function DialogTrigger({ ...props }: DialogTriggerProps) {
  return <Trigger data-slot="dialog-trigger" {...props} />;
}
export default DialogTrigger;
