import { Toast } from "@base-ui/react/toast";
import { cn } from "@narsil-cms/lib/utils";

function ToastContent({ className, ...props }: Toast.Content.Props) {
  return (
    <Toast.Content
      data-slot="toast-content"
      className={cn(
        "overflow-hidden transition-opacity duration-300",
        "data-behind:pointer-events-none data-behind:opacity-0",
        "data-expanded:pointer-events-auto data-expanded:opacity-100",
        className,
      )}
      {...props}
    />
  );
}

export default ToastContent;
