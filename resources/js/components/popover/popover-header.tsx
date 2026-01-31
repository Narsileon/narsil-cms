import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function PopoverHeader({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="popover-header"
      className={cn("flex flex-col gap-0.5 text-sm", className)}
      {...props}
    />
  );
}

export default PopoverHeader;
