import { Link } from "@inertiajs/react";
import parse from "html-react-parser";

import { Heading } from "@narsil-cms/blocks";
import { Builder } from "@narsil-cms/components/builder";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { getField } from "@narsil-cms/plugins/fields";
import { type BlockElementCondition, type HasElement } from "@narsil-cms/types";

import useForm from "./form-context";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";

type FormFieldRendererProps = HasElement & {
  className?: string;
  conditions?: BlockElementCondition[];
  onChange?: (value: any) => void;
};

function FormFieldRenderer({
  className,
  conditions,
  element,
  handle,
  name,
  width,
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
              "group col-span-full -mx-4 not-first:border-t",
              "first:-mt-4",
              "-mb-4",
              "data-[state=closed]:not-last:border-b",
            )}
            defaultOpen={true}
          >
            <CollapsibleTrigger
              className={cn(
                "flex w-full items-center justify-between bg-accent p-4 text-center",
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
            <CollapsibleContent className="grid grid-cols-12 gap-4 p-4">
              {element.elements?.map((element, index) => {
                return (
                  <FormFieldRenderer
                    conditions={element.conditions}
                    {...element}
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
                  {...element}
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
      <div className="col-span-full flex items-center justify-between">
        <span className="first-letter:uppercase">{finalName}</span>
        <span>{data?.[finalHandle]}</span>
      </div>
    );
  }

  return element.type === "Narsil\\Contracts\\Fields\\SectionElement" ? (
    <Heading
      className="col-span-full -mx-4 border-t border-b bg-accent p-4"
      level="h2"
    >
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
            width={width}
          >
            <div className="flex items-center justify-between gap-3">
              <FormLabel required={settings.required}>{finalName}</FormLabel>
              {settings.append
                ? parse(settings.append, {
                    replace: (domNode) => {
                      if (domNode.name === "a") {
                        return (
                          <Link
                            href={domNode.attribs.href}
                            className={domNode.attribs.class}
                          >
                            {domNode.children.map((c) => c.data).join("")}
                          </Link>
                        );
                      }
                    },
                  })
                : null}
            </div>
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
