import { cn } from "@/Components";
import { Content } from "@radix-ui/react-accordion";

export type AccordionContentProps = React.ComponentProps<typeof Content> & {};

function AccordionContent({
  className,
  children,
  ...props
}: AccordionContentProps) {
  return (
    <Content
      className={cn(
        "text-sm",
        "overflow-hidden transition-all",
        "data-[state=closed]:animate-accordion-up",
        "data-[state=open]:animate-accordion-down",
      )}
      data-slot="accordion-content"
      {...props}
    >
      <div className={cn("pt-0 pb-4", className)}>{children}</div>
    </Content>
  );
}

export default AccordionContent;
