import { ButtonRoot } from "@narsil-cms/components/button";
import { type ComponentProps } from "react";

function AlertDialogAction({ ...props }: ComponentProps<typeof ButtonRoot>) {
  return <ButtonRoot data-slot="alert-dialog-action" {...props} />;
}

export default AlertDialogAction;
