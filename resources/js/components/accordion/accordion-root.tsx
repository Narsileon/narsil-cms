import { Accordion } from "@base-ui/react/accordion";
import { cn } from "@narsil-cms/lib/utils";

function AccordionRoot({ className, ...props }: Accordion.Root.Props) {
  return (
    <Accordion.Root
      data-slot="accordion-root"
      className={cn("flex w-full flex-col", className)}
      {...props}
    />
  );
}

export default AccordionRoot;
