import { cn } from "@/Components";
import { Item } from "@radix-ui/react-accordion";

export type AccordionItemProps = React.ComponentProps<typeof Item> & {};

function AccordionItem({ className, ...props }: AccordionItemProps) {
  return (
    <Item
      className={cn("border-b last:border-b-0", className)}
      data-slot="accordion-item"
      {...props}
    />
  );
}

export default AccordionItem;
