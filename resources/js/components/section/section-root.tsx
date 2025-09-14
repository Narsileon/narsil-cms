import { cn } from "@narsil-cms/lib/utils";

type SectionRootProps = React.ComponentProps<"section"> & {};

const SectionRoot = ({ className, ...props }: SectionRootProps) => {
  return (
    <section
      data-slot="section-root"
      className={cn("flex flex-col gap-4", className)}
      {...props}
    />
  );
};

export default SectionRoot;
