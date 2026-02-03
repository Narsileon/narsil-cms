import { Icon } from "@narsil-cms/components/icon";
import { TabsList, TabsPanel, TabsRoot, TabsTab } from "@narsil-cms/components/tabs";
import { type IconName } from "@narsil-cms/registries/icons";
import { type ComponentProps, type ReactNode } from "react";

type TabsElement = {
  id: string;
  icon?: IconName;
  title: string;
  content: ReactNode;
};

type TabsProps = ComponentProps<typeof TabsRoot> & {
  elements: TabsElement[];
  TabsPanelProps?: Partial<ComponentProps<typeof TabsPanel>>;
  tabsListProps?: Partial<ComponentProps<typeof TabsList>>;
  TabsTabProps?: Partial<ComponentProps<typeof TabsTab>>;
};

function Tabs({ elements, TabsPanelProps, tabsListProps, TabsTabProps, ...props }: TabsProps) {
  return (
    <TabsRoot {...props}>
      <TabsList {...tabsListProps}>
        {elements.map((element) => {
          return (
            <TabsTab {...TabsTabProps} value={element.id} key={element.id}>
              {element.icon ? <Icon name={element.icon} /> : null}
              {element.title}
            </TabsTab>
          );
        })}
      </TabsList>
      {elements.map((element) => {
        return (
          <TabsPanel {...TabsPanelProps} value={element.id} key={element.id}>
            {element.content}
          </TabsPanel>
        );
      })}
    </TabsRoot>
  );
}

export default Tabs;
