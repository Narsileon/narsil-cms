import { cn } from "@/Components";
import { Description } from "@radix-ui/react-dialog";

export type DialogDescriptionProps = React.ComponentProps<
  typeof Description
> & {};

function DialogDescription({ className, ...props }: DialogDescriptionProps) {
  return (
    <Description
      data-slot="dialog-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default DialogDescription;
