import { Heading } from "@narsil-cms/components/heading";
import { cn } from "@narsil-cms/lib/utils";

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
