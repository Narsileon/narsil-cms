import { cn } from "@/components";
import { Dialog as DialogPrimitive } from "radix-ui";

export type DialogDescriptionProps = React.ComponentProps<
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
