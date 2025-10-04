import { Accordion } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AccordionHeaderProps = ComponentProps<typeof Accordion.Header>;

function AccordionHeader({ className, ...props }: AccordionHeaderProps) {
  return (
    <Accordion.Header
      data-slot="accordion-header"
      className={cn("flex", className)}
      {...props}
    />
  );
}

export default AccordionHeader;
