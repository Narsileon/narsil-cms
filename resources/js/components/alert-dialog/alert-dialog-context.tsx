import { AlertDialog } from "@narsil-cms/blocks/alert-dialog";
import { type ComponentProps, createContext, useContext } from "react";

export type AlertDialogContextProps = {
  setAlertDialog: (props: ComponentProps<typeof AlertDialog> | null) => void;
};

export const AlertDialogContext = createContext<AlertDialogContextProps | null>(null);

function useAlertDialog() {
  const context = useContext(AlertDialogContext);

  if (!context) {
    throw new Error("useAlertDialog must be used within a AlertDialogProvider.");
  }

  return context;
}

export default useAlertDialog;
