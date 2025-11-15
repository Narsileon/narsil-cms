import { AlertDialog } from "@narsil-cms/blocks";
import { useState, type ComponentProps } from "react";
import { AlertDialogContext } from "./alert-dialog-context";

type AlertDialogProviderProps = {
  children: React.ReactNode;
};

function AlertDialogProvider({ children }: AlertDialogProviderProps) {
  const [open, setOpen] = useState<ComponentProps<typeof AlertDialog> | null>(null);

  return (
    <AlertDialogContext.Provider value={{ setOpen: setOpen }}>
      {children}
      {open ? (
        <AlertDialog
          actionLabel={open.actionLabel}
          cancelLabel={open.cancelLabel}
          description={open.description}
          open={!!open}
          title={open.title}
          actionClick={(event) => {
            open.actionClick?.(event);

            setOpen(null);
          }}
          cancelClick={(event) => {
            open.cancelClick?.(event);

            setOpen(null);
          }}
        />
      ) : null}
    </AlertDialogContext.Provider>
  );
}

export default AlertDialogProvider;
