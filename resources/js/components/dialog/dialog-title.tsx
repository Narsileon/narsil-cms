import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogTitleProps = ComponentProps<typeof Dialog.Title>;

function DialogTitle({ className, ...props }: DialogTitleProps) {
  return (
    <Dialog.Title
      data-slot="dialog-title"
      className={cn("text-lg font-semibold leading-9", className)}
      {...props}
    />
  );
}

export default DialogTitle;
