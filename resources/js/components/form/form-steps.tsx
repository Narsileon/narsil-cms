import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-ui/components/collapsible";
import { FormElement, registry } from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { TabsList, TabsPanel, TabsRoot, TabsTab } from "@narsil-ui/components/tabs";
import { cn } from "@narsil-ui/lib/utils";
import { FormStepData } from "@narsil-ui/types";
import { useState } from "react";

type FormStepsProps = {
  steps: FormStepData[];
};

function FormSteps({ steps }: FormStepsProps) {
  const [value, setValue] = useState(steps[0].id);

  const tabsList =
    steps.length > 1 ? (
      <TabsList className="sticky top-0 z-10 flex w-full items-center border-b bg-background px-4">
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
          return (
            <FormElement
              {...element}
              registry={registry}
              render={(fieldset) => {
                return (
                  <CollapsibleRoot
                    className={cn("group col-span-full rounded border")}
                    disabled={!fieldset.collapsible}
                    defaultOpen={true}
                  >
                    <CollapsibleTrigger
                      className={cn(
                        "flex w-full items-center justify-between bg-muted px-4 py-2 text-center text-muted-foreground",
                      )}
                    >
                      <Heading level="h2">{fieldset.label}</Heading>
                      {fieldset.collapsible ? (
                        <Icon
                          className={cn("duration-300", "group-data-[state=open]:rotate-180")}
                          name="chevron-down"
                        />
                      ) : null}
                    </CollapsibleTrigger>
                    <CollapsiblePanel className="grid grid-cols-12 gap-8 p-4">
                      {fieldset.elements.map((fieldsetElement, index) => {
                        const virtualHandle =
                          fieldset.virtual === false
                            ? `${element.id}.${fieldsetElement.id}`
                            : (fieldsetElement.id as string);
                        return (
                          <FormElement
                            {...fieldsetElement}
                            id={virtualHandle}
                            registry={registry}
                            key={index}
                          />
                        );
                      })}
                    </CollapsiblePanel>
                  </CollapsibleRoot>
                );
              }}
              key={index}
            />
          );
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
