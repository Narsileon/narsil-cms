import { Accordion } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AccordionContentProps = React.ComponentProps<
  typeof Accordion.Content
> & {};

function AccordionContent({
  className,
  children,
  ...props
}: AccordionContentProps) {
  return (
    <Accordion.Content
      data-slot="accordion-content"
      className={cn(
        "overflow-hidden text-sm transition-all",
        "data-[state=closed]:animate-accordion-up",
        "data-[state=open]:animate-accordion-down",
      )}
      {...props}
    >
      <div className={cn("pt-0 pb-4", className)}>{children}</div>
    </Accordion.Content>
  );
}

export default AccordionContent;
