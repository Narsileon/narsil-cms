import { Button } from "@/blocks/button";
import {
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogOverlay,
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
  description?: string;
  title?: string;
  buttons?: ComponentProps<typeof Button>[];
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
      <AlertDialogTrigger asChild={true}>{children}</AlertDialogTrigger>
      <AlertDialogPortal>
        <AlertDialogOverlay />
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>{title ?? trans("dialogs.titles.default")}</AlertDialogTitle>
            <AlertDialogDescription>
              {description ?? trans("dialogs.descriptions.default")}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel onClick={cancelClick}>
              {cancelLabel ?? trans("ui.cancel")}
            </AlertDialogCancel>
            {buttons?.map((button, index) => {
              return (
                <AlertDialogAction
                  onClick={(event) => {
                    button.onClick?.(event);

                    setAlertDialog(null);
                  }}
                  key={index}
                >
                  {button.label ?? trans("ui.confirm")}
                </AlertDialogAction>
              );
            })}
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialogPortal>
    </AlertDialogRoot>
  );
}

export default AlertDialog;
