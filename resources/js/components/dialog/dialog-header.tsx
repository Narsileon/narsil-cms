import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type DialogHeaderProps = ComponentProps<"div"> & {};

function DialogHeader({ className, ...props }: DialogHeaderProps) {
  return (
    <div
      data-slot="dialog-header"
      className={cn(
        "[.border-b]:pb-3 flex flex-col gap-3 px-5 pt-3 text-left",
        className,
      )}
      {...props}
    />
  );
}
export default DialogHeader;
