import { cn } from "@/lib/utils";

type SectionHeaderProps = React.ComponentProps<"div"> & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <div
      data-slot="section-header"
      className={cn(
        "grid h-fit auto-rows-min grid-rows-[auto_auto] items-start [.border-b]:pb-6",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
