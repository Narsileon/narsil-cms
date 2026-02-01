import { AlertDialog } from "@base-ui/react/alert-dialog";
import { Button } from "@narsil-cms/components/button";

type AlertDialogCancelProps = AlertDialog.Close.Props &
  Pick<React.ComponentProps<typeof Button>, "variant" | "size">;

function AlertDialogCancel({ size, variant, ...props }: AlertDialogCancelProps) {
  return (
    <AlertDialog.Close
      data-slot="alert-dialog-cancel"
      render={<Button variant={variant} size={size} />}
      {...props}
    />
  );
}

export default AlertDialogCancel;
