import { Accordion } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AccordionItemProps = React.ComponentProps<typeof Accordion.Item> & {};

function AccordionItem({ className, ...props }: AccordionItemProps) {
  return (
    <Accordion.Item
      data-slot="accordion-item"
      className={cn("border-b", "last:border-b-0", className)}
      {...props}
    />
  );
}

export default AccordionItem;
