import { Builder } from "@narsil-cms/components/builder";
import { cn } from "@narsil-cms/lib/utils";
import { Heading } from "@narsil-cms/components/heading";
import { Icon } from "@narsil-cms/components/icon";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";
import useForm from "./form-context";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import type {
  Block,
  BlockElementCondition,
  Field,
  SelectOption,
} from "@narsil-cms/types/forms";
import { getField } from "@narsil-cms/plugins/fields";

type FormFieldRendererProps = {
  className?: string;
  conditions?: BlockElementCondition[];
  element: Field | Block;
  handle?: string | null;
  name?: string | null;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormFieldRenderer({
  className,
  conditions,
  element,
  handle,
  name,
  onChange,
}: FormFieldRendererProps) {
  const { data } = useForm();

  const finalHandle = handle ?? element.handle;
  const finalName = name ?? element.name;

  if ("elements" in element || "sets" in element) {
    return (
      <>
        {element.identifier.startsWith("blocks") ? (
          <CollapsibleRoot
            className={cn(
              "group -mx-4 not-first:border-t",
              "first:-mt-4",
              "-mb-4",
              "data-[state=closed]:not-last:border-b",
            )}
            defaultOpen={true}
          >
            <CollapsibleTrigger
              className={cn(
                "bg-accent flex w-full items-center justify-between p-4 text-center",
                "data-[state=open]:border-b",
              )}
            >
              <Heading level="h2">{finalName}</Heading>
              <Icon
                className={cn(
                  "duration-300",
                  "group-data-[state=open]:rotate-180",
                )}
                name="chevron-down"
              />
            </CollapsibleTrigger>
            <CollapsibleContent className="grid gap-4 p-4 px-4">
              {element.elements?.map((element, index) => {
                return (
                  <FormFieldRenderer
                    conditions={element.conditions}
                    element={element.element}
                    handle={element.handle}
                    name={element.name}
                    key={index}
                  />
                );
              })}
              {element.sets && element.sets.length > 0 ? (
                <Builder sets={element.sets} name={finalHandle} />
              ) : null}
            </CollapsibleContent>
          </CollapsibleRoot>
        ) : (
          <>
            {element.elements?.map((element, index) => {
              return (
                <FormFieldRenderer
                  conditions={element.conditions}
                  element={element.element}
                  handle={element.handle}
                  name={element.name}
                  key={index}
                />
              );
            })}
          </>
        )}
      </>
    );
  }

  const settings = element.settings ?? {};

  if (!element.type) {
    return (
      <div className="col-span-full flex items-center justify-between text-sm">
        <span className="first-letter:uppercase">{finalName}</span>
        <span>{data?.[finalHandle]}</span>
      </div>
    );
  }

  return element.type === "Narsil\\Contracts\\Fields\\SectionElement" ? (
    <Heading className="bg-accent -mx-4 border-t border-b p-4" level="h2">
      {finalName}
    </Heading>
  ) : (
    <FormField
      id={finalHandle}
      conditions={conditions}
      field={element}
      render={({ value, onFieldChange }) => {
        function handleOnChange(value: any) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FormItem
            className={cn(
              settings.type === "hidden" && "hidden",
              settings.className,
              className,
            )}
          >
            <FormLabel required={settings.required}>{finalName}</FormLabel>
            {getField(element.type, {
              id: finalHandle,
              element: element,
              value: value,
              setValue: handleOnChange,
            })}
            {element.description ? (
              <FormDescription>{element.description}</FormDescription>
            ) : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  );
}

export default FormFieldRenderer;
