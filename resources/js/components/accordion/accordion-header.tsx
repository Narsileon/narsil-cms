import { Accordion } from "@base-ui/react/accordion";
import { cn } from "@narsil-cms/lib/utils";

function AccordionHeader({ className, ...props }: Accordion.Header.Props) {
  return (
    <Accordion.Header data-slot="accordion-header" className={cn("flex", className)} {...props} />
  );
}

export default AccordionHeader;
