import { cn } from "@/lib/utils";

export type SectionContentProps = React.ComponentProps<"div"> & {};

function SectionContent({ className, ...props }: SectionContentProps) {
  return (
    <div
      data-slot="section-description"
      className={cn("px-6", className)}
      {...props}
    />
  );
}

export default SectionContent;
