import { Heading, NavigationMenu } from "@narsil-cms/blocks";
import { SectionContent, SectionRoot } from "@narsil-cms/components/section";

function Dashboard() {
  return (
    <SectionRoot className="h-full p-4">
      <SectionContent className="flex h-full w-full items-center justify-center">
        <Heading level="h1" variant="h3">
          Hello World!
        </Heading>
        <NavigationMenu />
      </SectionContent>
    </SectionRoot>
  );
}

export default Dashboard;
