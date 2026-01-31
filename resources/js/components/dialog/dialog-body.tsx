import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function DialogBody({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="dialog-body"
      className={cn(
        "flex w-full flex-col gap-5 overflow-hidden overflow-y-auto p-5 text-center sm:text-left",
        className,
      )}
      {...props}
    />
  );
}
export default DialogBody;
