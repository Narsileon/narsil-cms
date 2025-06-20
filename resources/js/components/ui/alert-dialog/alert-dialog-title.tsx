import { cn } from "@/components";
import { Title } from "@radix-ui/react-alert-dialog";

export type AlertDialogTitleProps = React.ComponentProps<typeof Title> & {};

function AlertDialogTitle({ className, ...props }: AlertDialogTitleProps) {
  return (
    <Title
      data-slot="alert-dialog-title"
      className={cn("text-lg font-semibold", className)}
      {...props}
    />
  );
}

export default AlertDialogTitle;
