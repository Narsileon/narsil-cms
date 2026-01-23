import { Icon } from "@narsil-cms/blocks/icon";
import { TabsContent, TabsList, TabsRoot, TabsTrigger } from "@narsil-cms/components/tabs";
import { type IconName } from "@narsil-cms/repositories/icons";
import { type ComponentProps, type ReactNode } from "react";

type TabsElement = {
  id: string;
  icon?: IconName;
  title: string;
  content: ReactNode;
};

type TabsProps = ComponentProps<typeof TabsRoot> & {
  elements: TabsElement[];
  tabsContentProps?: Partial<ComponentProps<typeof TabsContent>>;
  tabsListProps?: Partial<ComponentProps<typeof TabsList>>;
  tabsTriggerProps?: Partial<ComponentProps<typeof TabsTrigger>>;
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
        {elements.map((element) => {
          return (
            <TabsTrigger {...tabsTriggerProps} value={element.id} key={element.id}>
              {element.icon ? <Icon name={element.icon} /> : null}
              {element.title}
            </TabsTrigger>
          );
        })}
      </TabsList>
      {elements.map((element) => {
        return (
          <TabsContent {...tabsContentProps} value={element.id} key={element.id}>
            {element.content}
          </TabsContent>
        );
      })}
    </TabsRoot>
  );
}

export default Tabs;
