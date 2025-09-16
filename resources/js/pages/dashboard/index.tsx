import { NavigationMenu } from "@narsil-cms/blocks";
import { HeadingRoot } from "@narsil-cms/components/heading";
import { SectionContent, SectionRoot } from "@narsil-cms/components/section";

function Dashboard() {
  return (
    <SectionRoot className="h-full p-4">
      <SectionContent className="flex h-full w-full items-center justify-center">
        <HeadingRoot level="h1" variant="h3">
          Hello World!
        </HeadingRoot>
        <NavigationMenu />
      </SectionContent>
    </SectionRoot>
  );
}

export default Dashboard;
