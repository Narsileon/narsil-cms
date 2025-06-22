import { cn } from "@/lib/utils";

export type SectionTitleProps = React.ComponentProps<"div"> & {};

function SectionTitle({ className, ...props }: SectionTitleProps) {
  return (
    <div
      data-slot="section-title"
      className={cn("leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default SectionTitle;
