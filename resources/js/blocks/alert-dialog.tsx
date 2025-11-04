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
import React, { type ComponentProps } from "react";

type AlertDialogProps = ComponentProps<typeof AlertDialogRoot> & {
  action?: React.ReactNode;
  cancelLabel?: string;
  description?: string;
  title?: string;
};

function AlertDialog({
  action,
  cancelLabel,
  children,
  description,
  title,
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
            <AlertDialogTitle>{title ?? trans("ui.are_you_sure")}</AlertDialogTitle>
            <AlertDialogDescription>
              {description ?? trans("ui.are_you_sure_description")}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>{cancelLabel ?? trans("ui.cancel")}</AlertDialogCancel>
            <AlertDialogAction>{action}</AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialogPortal>
    </AlertDialogRoot>
  );
}

export default AlertDialog;
