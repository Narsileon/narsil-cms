import { Dialog as DialogPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DialogTitleProps = React.ComponentProps<typeof DialogPrimitive.Title> & {};

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <DialogPrimitive.Title
      data-slot="dialog-title"
      className={cn("text-lg leading-9 font-semibold", className)}
      {...props}
    />
  );
}

export default DialogTitle;
