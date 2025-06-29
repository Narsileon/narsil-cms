import { cn } from "@/lib/utils";

export type SectionHeaderProps = React.ComponentProps<"div"> & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <div
      data-slot="section-header"
      className={cn(
        "@container/section-header",
        "grid h-fit auto-rows-min grid-rows-[auto_auto] items-start border-b pb-4",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
