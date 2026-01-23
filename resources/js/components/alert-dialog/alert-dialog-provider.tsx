import { AlertDialog } from "@narsil-cms/blocks/alert-dialog";
import { useState, type ComponentProps, type ReactNode } from "react";
import { AlertDialogContext } from "./alert-dialog-context";

type AlertDialogProviderProps = {
  children: ReactNode;
};

function AlertDialogProvider({ children }: AlertDialogProviderProps) {
  const [alertDialog, setAlertDialog] = useState<ComponentProps<typeof AlertDialog> | null>(null);

  return (
    <AlertDialogContext.Provider value={{ setAlertDialog: setAlertDialog }}>
      {children}
      {alertDialog ? (
        <AlertDialog
          open={!!alertDialog}
          buttons={alertDialog.buttons}
          cancelLabel={alertDialog.cancelLabel}
          description={alertDialog.description}
          title={alertDialog.title}
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
