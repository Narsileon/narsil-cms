import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SectionHeaderProps = ComponentProps<"div"> & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <div
      data-slot="section-header"
      className={cn(
        "flex h-fit items-center justify-between [.border-b]:pb-3",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
