import { FormElement, registry } from "@narsil-ui/components/form";
import { TabsList, TabsPanel, TabsRoot, TabsTab } from "@narsil-ui/components/tabs";
import { FormStepData } from "@narsil-ui/types";
import { useState } from "react";

type FormStepsProps = {
  steps: FormStepData[];
};

function FormSteps({ steps }: FormStepsProps) {
  const [value, setValue] = useState(steps[0].id);

  const tabsList =
    steps.length > 1 ? (
      <TabsList className="flex w-full items-center border-b px-4">
        {steps.map((step, index) => {
          return (
            <TabsTab value={step.id} key={index}>
              {step.label}
            </TabsTab>
          );
        })}
      </TabsList>
    ) : null;

  const tabsPanels = steps.map((step, index) => {
    return (
      <TabsPanel
        className="grid w-full max-w-5xl grid-cols-12 gap-x-4 gap-y-8 place-self-center"
        value={step.id}
        key={index}
      >
        {step.elements?.map((element, index) => {
          return <FormElement {...element} registry={registry} key={index} />;
        })}
      </TabsPanel>
    );
  });

  return (
    <TabsRoot
      className="col-span-full"
      defaultValue={steps[0].id}
      value={value}
      onValueChange={setValue}
    >
      {tabsList}
      {tabsPanels}
    </TabsRoot>
  );
}

export default FormSteps;
