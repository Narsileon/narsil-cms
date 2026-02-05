import { FormElement } from "@narsil-cms/components/form";
import type { TemplateTab } from "@narsil-cms/types";
import { TabsList, TabsPanel, TabsRoot, TabsTab } from "@narsil-ui/components/tabs";
import { useState } from "react";

type FormStepsProps = {
  tabs: TemplateTab[];
};

function FormSteps({ tabs }: FormStepsProps) {
  const [value, setValue] = useState(tabs[0].handle);

  const tabsList =
    tabs.length > 1 ? (
      <TabsList className="flex w-full items-center border-b px-4">
        {tabs.map((tab, index) => {
          return (
            <TabsTab value={tab.handle} key={index}>
              {tab.label}
            </TabsTab>
          );
        })}
      </TabsList>
    ) : null;

  const tabsPanels = tabs.map((tab, index) => {
    return (
      <TabsPanel
        className="grid w-full max-w-5xl grid-cols-12 gap-x-4 gap-y-8 place-self-center"
        value={tab.handle}
        key={index}
      >
        {tab.elements?.map((element, index) => {
          return <FormElement {...element} key={index} />;
        })}
      </TabsPanel>
    );
  });

  return (
    <TabsRoot
      className="col-span-full"
      defaultValue={tabs[0].handle}
      value={value}
      onValueChange={setValue}
    >
      {tabsList}
      {tabsPanels}
    </TabsRoot>
  );
}

export default FormSteps;
