import { Accordion } from "@base-ui/react/accordion";
import { cn } from "@narsil-cms/lib/utils";

function AccordionTrigger({ className, ...props }: Accordion.Trigger.Props) {
  return (
    <Accordion.Trigger
      data-slot="accordion-trigger"
      className={cn(
        "group/accordion-trigger relative flex flex-1 items-start justify-between rounded-lg border border-transparent py-2.5 text-left font-medium transition-all outline-none",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:after:border-ring",
        "hover:underline",
        className,
      )}
      {...props}
    />
  );
}

export default AccordionTrigger;
