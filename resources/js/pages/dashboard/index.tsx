import { Heading } from "@narsil-cms/components/heading";
import { Section, SectionContent } from "@narsil-cms/components/section";

function Dashboard() {
  return (
    <Section className="h-full p-4">
      <SectionContent className="flex h-full w-full items-center justify-center">
        <Heading level="h1" variant="h3">
          Hello World!
        </Heading>
      </SectionContent>
    </Section>
  );
}

export default Dashboard;
