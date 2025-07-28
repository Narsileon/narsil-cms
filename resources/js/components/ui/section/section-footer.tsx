import { cn } from "@narsil-cms/lib/utils";

type SectionFooterProps = React.ComponentProps<"div"> & {};

function SectionFooter({ className, ...props }: SectionFooterProps) {
  return (
    <div
      data-slot="section-footer"
      className={cn("flex items-center [.border-t]:pt-3", className)}
      {...props}
    />
  );
}

export default SectionFooter;
