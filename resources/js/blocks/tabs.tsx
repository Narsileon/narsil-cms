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
  tabsContentProps?: Partial<React.ComponentProps<typeof TabsContent>>;
  tabsListProps?: Partial<React.ComponentProps<typeof TabsList>>;
  tabsTriggerProps?: Partial<React.ComponentProps<typeof TabsTrigger>>;
};

function Tabs({
  elements,
  tabsContentProps,
  tabsListProps,
  tabsTriggerProps,
  ...props
}: TabsProps) {
  return (
    <TabsRoot {...props}>
      <TabsList {...tabsListProps}>
        {elements.map((element) => (
          <TabsTrigger
            {...tabsTriggerProps}
            value={element.id}
            key={element.id}
          >
            {element.icon ? <Icon name={element.icon} /> : null}
            {element.title}
          </TabsTrigger>
        ))}
      </TabsList>
      {elements.map((element) => (
        <TabsContent {...tabsContentProps} value={element.id} key={element.id}>
          {element.content}
        </TabsContent>
      ))}
    </TabsRoot>
  );
}

export default Tabs;
