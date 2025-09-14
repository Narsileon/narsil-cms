import { Dialog } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DialogTitleProps = React.ComponentProps<typeof Dialog.Title> & {};

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <Dialog.Title
      data-slot="dialog-title"
      className={cn("text-lg leading-9 font-semibold", className)}
      {...props}
    />
  );
}

export default DialogTitle;
