import { Trigger } from "@radix-ui/react-alert-dialog";

export type AlertDialogTriggerProps = React.ComponentProps<typeof Trigger> & {};

function AlertDialogTrigger({ ...props }: AlertDialogTriggerProps) {
  return <Trigger data-slot="alert-dialog-trigger" {...props} />;
}

export default AlertDialogTrigger;
