import { cn } from "@narsil-cms/lib/utils";

type SectionHeaderProps = React.ComponentProps<"div"> & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <div
      data-slot="section-header"
      className={cn(
        "flex h-fit items-center justify-between [.border-b]:pb-6",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
