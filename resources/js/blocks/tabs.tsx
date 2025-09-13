import { Icon } from "@narsil-cms/components/icon";
import {
  TabsContent,
  TabsList,
  TabsRoot,
  TabsTrigger,
} from "@narsil-cms/components/tabs";
import { type IconName } from "@narsil-cms/plugins/icons";

type TabsElement = {
  id: string;
  icon?: IconName;
  title: string;
  content: React.ReactNode;
};

type TabsProps = React.ComponentProps<typeof TabsRoot> & {
  elements: TabsElement[];
};

function Tabs({ elements, ...props }: TabsProps) {
  return (
    <TabsRoot {...props}>
      <TabsList>
        {elements.map((element) => (
          <TabsTrigger value={element.id} key={element.id}>
            {element.icon ? <Icon name={element.icon} /> : null}
            {element.title}
          </TabsTrigger>
        ))}
      </TabsList>
      {elements.map((element) => (
        <TabsContent value={element.id} key={element.id}>
          {element.content}
        </TabsContent>
      ))}
    </TabsRoot>
  );
}

export default Tabs;
