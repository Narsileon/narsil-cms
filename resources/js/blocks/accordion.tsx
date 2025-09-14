import {
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
  AccordionHeader,
  AccordionRoot,
} from "@narsil-cms/components/accordion";
import { HeadingRoot } from "@narsil-cms/components/heading";
import { Icon } from "@narsil-cms/components/icon";

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
          <AccordionHeader asChild>
            <HeadingRoot level="h2">
              <AccordionTrigger>
                {element.title}
                <Icon
                  className={
                    "transition-transform duration-300 will-change-transform group-data-[state=open]:rotate-180"
                  }
                  name="chevron-down"
                />
              </AccordionTrigger>
            </HeadingRoot>
          </AccordionHeader>
          <AccordionContent>{element.content}</AccordionContent>
        </AccordionItem>
      ))}
    </AccordionRoot>
  );
}

export default Accordion;
