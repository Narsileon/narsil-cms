import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function SectionRoot({ className, ...props }: ComponentProps<"section">) {
  return (
    <section data-slot="section-root" className={cn("flex flex-col gap-4", className)} {...props} />
  );
}

export default SectionRoot;
