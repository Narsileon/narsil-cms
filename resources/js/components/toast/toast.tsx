import { Toast as ToastPrimitive } from "@base-ui/react/toast";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { useEffect } from "react";
import ToastClose from "./toast-close";
import ToastContent from "./toast-content";
import ToastDescription from "./toast-description";
import ToastPortal from "./toast-portal";
import ToastRoot from "./toast-root";
import ToastTitle from "./toast-title";
import ToastViewport from "./toast-viewport";

function Toast({ error, info, success, warning }: GlobalProps["redirect"]) {
  const { add, toasts } = ToastPrimitive.useToastManager();

  useEffect(() => {
    if (error) {
      add({
        description: error,
      });
    } else if (info) {
      add({
        description: info,
      });
    } else if (success) {
      add({
        description: success,
      });
    } else if (warning) {
      add({
        description: warning,
      });
    }
  }, [error, info, success, warning]);

  return (
    <ToastPortal>
      <ToastViewport>
        {toasts.map((toast) => {
          return (
            <ToastRoot toast={toast} key={toast.id}>
              <ToastContent>
                <ToastTitle />
                <ToastDescription />
                <ToastClose />
              </ToastContent>
            </ToastRoot>
          );
        })}
      </ToastViewport>
    </ToastPortal>
  );
}

export default Toast;
