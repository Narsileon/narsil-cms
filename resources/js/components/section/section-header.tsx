import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SectionHeaderProps = ComponentProps<"div"> & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <div
      data-slot="section-header"
      className={cn(
        "[.border-b]:pb-3 flex h-fit items-center justify-between",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
