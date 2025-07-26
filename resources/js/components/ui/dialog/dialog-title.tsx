import { cn } from "@narsil-cms/lib/utils";
import { Dialog as DialogPrimitive } from "radix-ui";

type DialogTitleProps = React.ComponentProps<typeof DialogPrimitive.Title> & {};

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <DialogPrimitive.Title
      data-slot="dialog-title"
      className={cn("min-h-9 text-lg leading-relaxed font-semibold", className)}
      {...props}
    />
  );
}

export default DialogTitle;
