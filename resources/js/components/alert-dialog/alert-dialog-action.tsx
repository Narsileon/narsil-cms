import { Button } from "@narsil-cms/components/button";
import { type ComponentProps } from "react";

function AlertDialogAction({ ...props }: ComponentProps<typeof Button>) {
  return <Button data-slot="alert-dialog-action" {...props} />;
}

export default AlertDialogAction;
