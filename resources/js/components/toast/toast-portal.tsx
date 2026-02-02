import { Toast } from "@base-ui/react/toast";

function ToastPortal({ ...props }: Toast.Portal.Props) {
  return <Toast.Portal data-slot="toast-portal" {...props} />;
}

export default ToastPortal;
