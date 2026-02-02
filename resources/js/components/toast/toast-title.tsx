import { Toast } from "@base-ui/react/toast";
import { cn } from "@narsil-cms/lib/utils";

function ToastTitle({ className, ...props }: Toast.Title.Props) {
  return (
    <Toast.Title
      data-slot="toast-title"
      className={cn("text-sm leading-5 font-medium", className)}
      {...props}
    />
  );
}

export default ToastTitle;
