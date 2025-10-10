import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SectionFooterProps = ComponentProps<"div">;

function SectionFooter({ className, ...props }: SectionFooterProps) {
  return (
    <div
      data-slot="section-footer"
      className={cn("[.border-t]:pt-3 flex items-center", className)}
      {...props}
    />
  );
}

export default SectionFooter;
