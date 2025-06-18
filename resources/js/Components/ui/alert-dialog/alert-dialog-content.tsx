import { cn } from "@/Components";
import { Content } from "@radix-ui/react-alert-dialog";
import AlertDialogPortal from "./alert-dialog-portal";
import AlertDialogOverlay from "./alert-dialog-overlay";

export type AlertDialogContentProps = React.ComponentProps<typeof Content> & {};

function AlertDialogContent({ className, ...props }: AlertDialogContentProps) {
  return (
    <AlertDialogPortal>
      <AlertDialogOverlay />
      <Content
        className={cn(
          "bg-background fixed top-[50%] left-[50%]",
          "z-50 grid w-full gap-4 rounded-lg border p-6 shadow-lg sm:max-w-lg",
          "max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] duration-200",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          className,
        )}
        data-slot="alert-dialog-content"
        {...props}
      />
    </AlertDialogPortal>
  );
}

export default AlertDialogContent;
