import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function LabelRequired({ className, ...props }: ComponentProps<"span">) {
  return (
    <span data-slot="label-required" className={cn("text-destructive", className)} {...props}>
      *
    </span>
  );
}

export default LabelRequired;
