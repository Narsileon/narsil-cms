import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type SectionProps = React.ComponentProps<"section"> & {};

const Section = ({ className, ...props }: SectionProps) => {
  return (
    <section
      data-slot="section"
      className={cn("flex flex-col gap-4", className)}
      {...props}
    />
  );
};

export default Section;
