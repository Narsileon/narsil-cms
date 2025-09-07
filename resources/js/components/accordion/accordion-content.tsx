import * as React from "react";
import { Accordion as AccordionPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";

type AccordionContentProps = React.ComponentProps<
  typeof AccordionPrimitive.Content
> & {};

function AccordionContent({
  className,
  children,
  ...props
}: AccordionContentProps) {
  return (
    <AccordionPrimitive.Content
      data-slot="accordion-content"
      className={cn(
        "overflow-hidden text-sm transition-all",
        "data-[state=closed]:animate-accordion-up",
        "data-[state=open]:animate-accordion-down",
      )}
      {...props}
    >
      <div className={cn("pt-0 pb-4", className)}>{children}</div>
    </AccordionPrimitive.Content>
  );
}

export default AccordionContent;
