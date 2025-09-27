import { type ComponentProps, type ReactNode } from "react";

import { Heading } from "@narsil-cms/blocks";
import {
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
  AccordionHeader,
  AccordionRoot,
} from "@narsil-cms/components/accordion";
import { Icon } from "@narsil-cms/components/icon";

type AccordionElement = {
  id: string;
  title: string;
  content: ReactNode;
};

type AccordionProps = ComponentProps<typeof AccordionRoot> & {
  elements: AccordionElement[];
};

function Accordion({ elements, ...props }: AccordionProps) {
  return (
    <AccordionRoot {...props}>
      {elements.map((element) => (
        <AccordionItem value={element.id} key={element.id}>
          <AccordionHeader asChild>
            <Heading level="h2">
              <AccordionTrigger>
                {element.title}
                <Icon
                  className={
                    "transition-transform duration-300 will-change-transform group-data-[state=open]:rotate-180"
                  }
                  name="chevron-down"
                />
              </AccordionTrigger>
            </Heading>
          </AccordionHeader>
          <AccordionContent>{element.content}</AccordionContent>
        </AccordionItem>
      ))}
    </AccordionRoot>
  );
}

export default Accordion;
