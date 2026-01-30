import { Accordion } from "@base-ui/react/accordion";
import { cn } from "@narsil-cms/lib/utils";

function AccordionItem({ className, ...props }: Accordion.Item.Props) {
  return (
    <Accordion.Item
      data-slot="accordion-item"
      className={cn("not-last:border-b", className)}
      {...props}
    />
  );
}

export default AccordionItem;
