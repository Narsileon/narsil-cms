import {
  AlertDialogAction,
  AlertDialogBackdrop,
  AlertDialogCancel,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogPopup,
  AlertDialogPortal,
  AlertDialogRoot,
  AlertDialogTitle,
  AlertDialogTrigger,
  useAlertDialog,
} from "@narsil-cms/components/alert-dialog";
import { useLocalization } from "@narsil-cms/components/localization";
import { type ComponentProps, type MouseEventHandler } from "react";

type AlertDialogProps = ComponentProps<typeof AlertDialogRoot> & {
  cancelLabel?: string;
  children: React.ReactNode;
  description?: string;
  title?: string;
  buttons?: ComponentProps<typeof AlertDialogAction>[];
  cancelClick?: MouseEventHandler<HTMLButtonElement>;
};

function AlertDialog({
  buttons,
  cancelLabel,
  children,
  description,
  title,
  cancelClick,
  ...props
}: AlertDialogProps) {
  const { setAlertDialog } = useAlertDialog();
  const { trans } = useLocalization();

  return (
    <AlertDialogRoot {...props}>
      <AlertDialogTrigger>{children}</AlertDialogTrigger>
      <AlertDialogPortal>
        <AlertDialogBackdrop />
        <AlertDialogPopup>
          <AlertDialogHeader>
            <AlertDialogTitle>{title ?? trans("dialogs.titles.default")}</AlertDialogTitle>
            <AlertDialogDescription>
              {description ?? trans("dialogs.descriptions.default")}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <div className="flex items-center gap-2">
              {buttons?.map((button, index) => {
                return (
                  <AlertDialogAction
                    onClick={(event) => {
                      button.onClick?.(event);

                      setAlertDialog(null);
                    }}
                    key={index}
                  >
                    {button.children ?? trans("ui.confirm")}
                  </AlertDialogAction>
                );
              })}
            </div>
            <AlertDialogCancel onClick={cancelClick}>
              {cancelLabel ?? trans("ui.cancel")}
            </AlertDialogCancel>
          </AlertDialogFooter>
        </AlertDialogPopup>
      </AlertDialogPortal>
    </AlertDialogRoot>
  );
}

export default AlertDialog;
