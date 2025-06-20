import { cn } from "@/components";
import { Title } from "@radix-ui/react-dialog";

export type DialogTitleProps = React.ComponentProps<typeof Title> & {};

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <Title
      data-slot="dialog-title"
      className={cn("text-lg leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default DialogTitle;
