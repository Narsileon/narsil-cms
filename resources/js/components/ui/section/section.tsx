import { cn } from "@/lib/utils";

export type SectionProps = React.ComponentProps<"section"> & {};

const Section = ({ className, ...props }: SectionProps) => {
  return (
    <section
      data-slot="section"
      className={cn("flex flex-col gap-4 py-4", className)}
      {...props}
    />
  );
};

export default Section;
