import { Accordion } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AccordionTriggerProps = React.ComponentProps<
  typeof Accordion.Trigger
> & {};

function AccordionTrigger({ className, ...props }: AccordionTriggerProps) {
  return (
    <Accordion.Trigger
      data-slot="accordion-trigger"
      className={cn(
        "group flex flex-1 cursor-pointer items-start justify-between gap-4 rounded-md py-4 text-left text-sm transition-all outline-none",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
        "hover:underline",
        className,
      )}
      {...props}
    />
  );
}

export default AccordionTrigger;
