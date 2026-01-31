import { Accordion } from "@base-ui/react/accordion";
import { cn } from "@narsil-cms/lib/utils";

function AccordionPanel({ children, className, ...props }: Accordion.Panel.Props) {
  return (
    <Accordion.Panel
      data-slot="accordion-panel"
      className={cn(
        "overflow-hidden text-sm",
        "data-open:animate-accordion-down",
        "data-closed:animate-accordion-up",
      )}
      {...props}
    >
      <div
        className={cn(
          "h-(--accordion-panel-height) pt-0 pb-2.5",
          "[&_a]:underline [&_a]:underline-offset-3 [&_a]:hover:text-foreground",
          "[&_p:not(:last-child)]:mb-4",
          "data-ending-style:h-0",
          "data-starting-style:h-0",
          className,
        )}
      >
        {children}
      </div>
    </Accordion.Panel>
  );
}

export default AccordionPanel;
