import { Toast } from "@base-ui/react/toast";
import { cn } from "@narsil-cms/lib/utils";

function ToastDescription({ className, ...props }: Toast.Description.Props) {
  return (
    <Toast.Description
      data-slot="toast-description"
      className={cn("text-sm leading-5", className)}
      {...props}
    />
  );
}

export default ToastDescription;
