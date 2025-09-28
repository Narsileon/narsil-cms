import { Link } from "@inertiajs/react";
import parse from "html-react-parser";
import { Fragment } from "react";

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
import {
  Block,
  Field,
  TemplateSection,
  type BlockElementCondition,
  type HasElement,
} from "@narsil-cms/types";

import useForm from "./form-context";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";

type FormRendererProps = (Block | Field | TemplateSection) & {
  className?: string;
  conditions?: BlockElementCondition[];
  elements?: HasElement[];
  sets?: Block[];
  settings?: Field["settings"];
  type?: Field["type"];
  width?: number;
  onChange?: (value: unknown) => void;
};

function FormRenderer({
  className,
  conditions,
  elements,
  sets,
  width,
  onChange,
  ...props
}: FormRendererProps) {
  const { data } = useForm();

  if (elements || sets) {
    return (
      <>
        {elements?.map((element, index) => {
          const childElement = element.element;

          return (
            <Fragment key={index}>
              {"elements" in childElement || "sets" in childElement ? (
                <CollapsibleRoot
                  className={cn(
                    "group col-span-full -mx-4 not-first:border-t",
                    "first:-mt-4",
                    "-mb-4",
                    "data-[state=closed]:not-last:border-b",
                  )}
                  disabled={!childElement.collapsible}
                  defaultOpen={true}
                >
                  <CollapsibleTrigger
                    className={cn(
                      "flex w-full items-center justify-between bg-accent p-4 text-center",
                      "data-[state=open]:border-b",
                    )}
                  >
                    <Heading level="h2">{childElement.name}</Heading>
                    <Icon
                      className={cn(
                        "duration-300",
                        "group-data-[state=open]:rotate-180",
                      )}
                      name="chevron-down"
                    />
                  </CollapsibleTrigger>
                  <CollapsibleContent className="grid grid-cols-12 gap-4 p-4">
                    <FormRenderer
                      {...childElement}
                      handle={element.handle ?? childElement.handle}
                      name={element.name ?? childElement.name}
                      width={element.width}
                    />
                    {childElement.sets && childElement.sets.length > 0 ? (
                      <Builder
                        sets={childElement.sets}
                        name={element.handle ?? childElement.handle}
                      />
                    ) : null}
                  </CollapsibleContent>
                </CollapsibleRoot>
              ) : (
                <FormRenderer
                  {...childElement}
                  handle={element.handle ?? childElement.handle}
                  name={element.name ?? childElement.name}
                  width={element.width}
                />
              )}
            </Fragment>
          );
        })}
      </>
    );
  }

  if (!props.type) {
    return (
      <div className="col-span-full flex items-center justify-between">
        <span className="first-letter:uppercase">{props.name}</span>
        <span>{data?.[props.handle]}</span>
      </div>
    );
  }

  return (
    <FormField
      id={props.handle}
      conditions={conditions}
      field={props}
      render={({ value, onFieldChange }) => {
        function handleOnChange(value: unknown) {
          onChange?.(value);
          onFieldChange(value);
        }

        // flex-row-reverse
        return (
          <FormItem
            className={cn(
              props.settings?.type === "hidden" && "hidden",
              props.settings?.className,
              className,
            )}
            width={width}
          >
            <div className="flex items-center justify-between gap-3">
              <FormLabel required={props.settings?.required}>
                {props.name}
              </FormLabel>
              {props.settings?.append
                ? parse(props.settings.append, {
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
            {getField(props.type, {
              id: props.handle,
              element: props,
              value: value,
              setValue: handleOnChange,
            })}
            {props.description ? (
              <FormDescription>{props.description}</FormDescription>
            ) : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  );
}

export default FormRenderer;
