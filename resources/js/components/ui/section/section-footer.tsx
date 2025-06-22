import { cn } from "@/lib/utils";

export type SectionFooterProps = React.ComponentProps<"div"> & {};

function SectionFooter({ className, ...props }: SectionFooterProps) {
  return (
    <div
      data-slot="section-footer"
      className={cn("flex items-center border-t pt-4", className)}
      {...props}
    />
  );
}

export default SectionFooter;
