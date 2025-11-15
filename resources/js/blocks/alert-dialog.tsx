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
} from "@narsil-cms/components/alert-dialog";
import { useLocalization } from "@narsil-cms/components/localization";
import React, { type ComponentProps, type MouseEventHandler } from "react";

type AlertDialogProps = ComponentProps<typeof AlertDialogRoot> & {
  actionLabel?: React.ReactNode;
  cancelLabel?: string;
  description?: string;
  title?: string;
  actionClick?: MouseEventHandler<HTMLButtonElement>;
  cancelClick?: MouseEventHandler<HTMLButtonElement>;
};

function AlertDialog({
  actionLabel,
  cancelLabel,
  children,
  description,
  title,
  actionClick,
  cancelClick,
  ...props
}: AlertDialogProps) {
  const { trans } = useLocalization();

  return (
    <AlertDialogRoot {...props}>
      <AlertDialogTrigger asChild={true}>{children}</AlertDialogTrigger>
      <AlertDialogPortal>
        <AlertDialogOverlay />
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>{title ?? trans("dialogs.titles.confirm")}</AlertDialogTitle>
            <AlertDialogDescription>
              {description ?? trans("dialogs.descriptions.confirm")}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel onClick={cancelClick}>
              {cancelLabel ?? trans("ui.cancel")}
            </AlertDialogCancel>
            <AlertDialogAction onClick={actionClick}>
              {actionLabel ?? trans("ui.confirm")}
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialogPortal>
    </AlertDialogRoot>
  );
}

export default AlertDialog;
