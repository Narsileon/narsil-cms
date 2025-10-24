import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type DialogHeaderProps = ComponentProps<"div">;

function DialogHeader({ className, ...props }: DialogHeaderProps) {
  return (
    <div
      data-slot="dialog-header"
      className={cn("flex h-13 items-center gap-2 px-4 pt-2 [.border-b]:pb-2", className)}
      {...props}
    />
  );
}
export default DialogHeader;
