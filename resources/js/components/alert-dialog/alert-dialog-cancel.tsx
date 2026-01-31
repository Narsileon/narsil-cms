import { AlertDialog } from "@base-ui/react/alert-dialog";
import { ButtonRoot } from "@narsil-cms/components/button";

type AlertDialogCancelProps = AlertDialog.Close.Props &
  Pick<React.ComponentProps<typeof ButtonRoot>, "variant" | "size">;

function AlertDialogCancel({ size, variant, ...props }: AlertDialogCancelProps) {
  return (
    <AlertDialog.Close
      data-slot="alert-dialog-cancel"
      render={<ButtonRoot variant={variant} size={size} />}
      {...props}
    />
  );
}

export default AlertDialogCancel;
