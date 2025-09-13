import {
  AccordionRoot,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
  AccordionHeader,
} from "@narsil-cms/components/accordion";

type AccordionElement = {
  id: string;
  title: string;
  content: React.ReactNode;
};

type AccordionProps = React.ComponentProps<typeof AccordionRoot> & {
  elements: AccordionElement[];
};

function Accordion({ elements, ...props }: AccordionProps) {
  return (
    <AccordionRoot {...props}>
      {elements.map((element) => (
        <AccordionItem value={element.id} key={element.id}>
          <AccordionHeader>
            <AccordionTrigger>{element.title}</AccordionTrigger>
          </AccordionHeader>
          <AccordionContent>{element.content}</AccordionContent>
        </AccordionItem>
      ))}
    </AccordionRoot>
  );
}

export default Accordion;
