import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Heading } from "@narsil-cms/components/ui/heading";

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
