import { cn } from "@/lib/utils";
import { Heading } from "@/components/ui/heading";
import type { HeadingProps } from "@/components/ui/heading";

export type SectionTitleProps = HeadingProps & {};

function SectionTitle({ className, ...props }: SectionTitleProps) {
  return (
    <Heading
      data-slot="section-title"
      className={cn("leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default SectionTitle;
