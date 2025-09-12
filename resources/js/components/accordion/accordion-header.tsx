import { Accordion as AccordionPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AccordionHeaderProps = React.ComponentProps<
  typeof AccordionPrimitive.Header
> & {};

function AccordionHeader({ className, ...props }: AccordionHeaderProps) {
  return (
    <AccordionPrimitive.Header
      data-slot="accordion-header"
      className={cn("flex", className)}
      {...props}
    />
  );
}

export default AccordionHeader;
