import { cn } from "@/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";

type DialogDescriptionProps = React.ComponentProps<
  typeof DialogPrimitive.Description
> & {};

function DialogDescription({ className, ...props }: DialogDescriptionProps) {
  return (
    <DialogPrimitive.Description
      data-slot="dialog-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default DialogDescription;
