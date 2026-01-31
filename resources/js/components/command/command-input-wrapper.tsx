import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function CommandInputWrapper({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="command-input-wrapper"
      className={cn("flex h-9 items-center gap-2 border-b px-3", className)}
      {...props}
    />
  );
}

export default CommandInputWrapper;
