import { Root } from "@radix-ui/react-alert-dialog";

export type AlertDialogProps = React.ComponentProps<typeof Root> & {};

function AlertDialog({ ...props }: AlertDialogProps) {
  return <Root data-slot="alert-dialog" {...props} />;
}

export default AlertDialog;
