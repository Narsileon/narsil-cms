import { ButtonRoot } from "@/components/button";
import { AlertDialog } from "@base-ui/react/alert-dialog";

function AlertDialogCancel({
  size,
  variant,
  ...props
}: AlertDialog.Close.Props & Pick<React.ComponentProps<typeof ButtonRoot>, "variant" | "size">) {
  return (
    <AlertDialog.Close
      data-slot="alert-dialog-cancel"
      render={<ButtonRoot variant={variant} size={size} />}
      {...props}
    />
  );
}

export default AlertDialogCancel;
