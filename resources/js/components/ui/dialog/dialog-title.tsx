import { cn } from "@/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";

export type DialogTitleProps = React.ComponentProps<
  typeof DialogPrimitive.Title
> & {};

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <DialogPrimitive.Title
      data-slot="dialog-title"
      className={cn("text-lg leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default DialogTitle;
