import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function LabelRoot({ className, ...props }: ComponentProps<"label">) {
  return (
    <label
      data-slot="label-root"
      className={cn(
        "flex items-center leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default LabelRoot;
