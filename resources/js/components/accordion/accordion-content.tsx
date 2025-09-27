import { Accordion } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AccordionContentProps = ComponentProps<typeof Accordion.Content> & {};

function AccordionContent({ className, ...props }: AccordionContentProps) {
  return (
    <Accordion.Content
      data-slot="accordion-content"
      className={cn(
        "overflow-hidden pb-4 transition-all",
        "data-[state=closed]:animate-accordion-up",
        "data-[state=open]:animate-accordion-down",
        className,
      )}
      {...props}
    />
  );
}

export default AccordionContent;
