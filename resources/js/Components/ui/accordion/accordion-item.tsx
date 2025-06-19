import { cn } from "@/Components";
import { Item } from "@radix-ui/react-accordion";

export type AccordionItemProps = React.ComponentProps<typeof Item> & {};

function AccordionItem({ className, ...props }: AccordionItemProps) {
  return (
    <Item
      data-slot="accordion-item"
      className={cn("border-b", "last:border-b-0", className)}
      {...props}
    />
  );
}

export default AccordionItem;
