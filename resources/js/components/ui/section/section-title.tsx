import { cn } from "@/lib/utils";
import { Heading } from "@/components/ui/heading";

type SectionTitleProps = React.ComponentProps<typeof Heading> & {};

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
