import { cn } from "@/lib/utils";
import { Heading, HeadingProps } from "@/components/ui/heading";

export type SectionHeaderProps = HeadingProps & {};

function SectionHeader({ className, ...props }: SectionHeaderProps) {
  return (
    <Heading
      data-slot="section-header"
      className={cn(
        "@container/section-header",
        "grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 [.border-b]:pb-6",
        className,
      )}
      {...props}
    />
  );
}

export default SectionHeader;
