import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-ui/components/collapsible";
import { FormElement } from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { cn } from "@narsil-ui/lib/utils";
import type { FieldsetData } from "@narsil-ui/types";

type FormBlockProps = {
  baseId: string | number;
  fieldset: FieldsetData;
};

function FormBlock({ baseId, fieldset }: FormBlockProps) {
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
            fieldset.virtual !== true
              ? `${baseId}.${fieldsetElement.id}`
              : (fieldsetElement.id as string);
          return (
            <FormElement
              {...fieldsetElement}
              id={virtualHandle}
              render={(fieldset) => {
                return <FormBlock baseId={virtualHandle} fieldset={fieldset} />;
              }}
              key={index}
            />
          );
        })}
      </CollapsiblePanel>
    </CollapsibleRoot>
  );
}

export default FormBlock;
