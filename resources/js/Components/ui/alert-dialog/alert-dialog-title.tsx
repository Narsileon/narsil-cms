import { cn } from "@/Components";
import { Title } from "@radix-ui/react-alert-dialog";

export type AlertDialogTitleProps = React.ComponentProps<typeof Title> & {};

function AlertDialogTitle({ className, ...props }: AlertDialogTitleProps) {
  return (
    <Title
      className={cn("text-lg font-semibold", className)}
      data-slot="alert-dialog-title"
      {...props}
    />
  );
}

export default AlertDialogTitle;
