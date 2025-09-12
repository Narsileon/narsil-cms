import { Accordion as AccordionPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AccordionItemProps = React.ComponentProps<
  typeof AccordionPrimitive.Item
> & {};

function AccordionItem({ className, ...props }: AccordionItemProps) {
  return (
    <AccordionPrimitive.Item
      data-slot="accordion-item"
      className={cn("border-b", "last:border-b-0", className)}
      {...props}
    />
  );
}

export default AccordionItem;
