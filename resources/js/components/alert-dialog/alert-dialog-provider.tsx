import { AlertDialog } from "@narsil-cms/blocks";
import { useState, type ComponentProps } from "react";
import { AlertDialogContext } from "./alert-dialog-context";

type AlertDialogProviderProps = {
  children: React.ReactNode;
};

function AlertDialogProvider({ children }: AlertDialogProviderProps) {
  const [alertDialog, setAlertDialog] = useState<ComponentProps<typeof AlertDialog> | null>(null);

  return (
    <AlertDialogContext.Provider value={{ setAlertDialog: setAlertDialog }}>
      {children}
      {alertDialog ? (
        <AlertDialog
          open={!!alertDialog}
          actionLabel={alertDialog.actionLabel}
          cancelLabel={alertDialog.cancelLabel}
          description={alertDialog.description}
          title={alertDialog.title}
          actionClick={(event) => {
            alertDialog.actionClick?.(event);

            setAlertDialog(null);
          }}
          cancelClick={(event) => {
            alertDialog.cancelClick?.(event);

            setAlertDialog(null);
          }}
        />
      ) : null}
    </AlertDialogContext.Provider>
  );
}

export default AlertDialogProvider;
