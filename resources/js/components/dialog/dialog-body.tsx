import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogBodyProps = ComponentProps<"div"> & {};

function DialogBody({ className, ...props }: DialogBodyProps) {
  return (
    <div
      data-slot="dialog-body"
      className={cn(
        "flex flex-col gap-5 overflow-hidden overflow-y-auto p-5 text-center sm:text-left",
        className,
      )}
      {...props}
    />
  );
}
export default DialogBody;
