import { AlertDialog } from "@narsil-cms/blocks";
import { type ComponentProps, createContext, useContext } from "react";

export type AlertDialogContextProps = {
  setOpen: (props: ComponentProps<typeof AlertDialog>) => void;
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
