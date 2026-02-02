import { Toast } from "@base-ui/react/toast";

function ToastViewport({ ...props }: Toast.Viewport.Props) {
  return (
    <Toast.Viewport
      data-slot="toast-viewport"
      className="bottom4 fixed top-auto right-4 z-10 mx-auto flex w-62 sm:right-8 sm:bottom-8 sm:w-75"
      {...props}
    />
  );
}

export default ToastViewport;
