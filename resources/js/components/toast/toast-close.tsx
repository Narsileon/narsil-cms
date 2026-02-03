import { Toast } from "@base-ui/react/toast";
import { Icon } from "@narsil-cms/components/icon";

function ToastClose({ children, className, ...props }: Toast.Close.Props) {
  return (
    <Toast.Close
      data-slot="toast-close"
      className="absolute top-2 right-2 flex size-5 items-center justify-center rounded border-none bg-transparent"
      aria-label="Close"
      {...props}
    >
      {children ?? <Icon className="size-4" name="x" />}
    </Toast.Close>
  );
}

export default ToastClose;
