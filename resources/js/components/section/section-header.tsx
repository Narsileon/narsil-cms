import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function SectionHeader({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="section-header"
      className={cn("flex h-fit items-center justify-between [.border-b]:pb-3", className)}
      {...props}
    />
  );
}

export default SectionHeader;
