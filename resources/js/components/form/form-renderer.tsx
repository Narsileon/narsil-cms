import { Link } from "@inertiajs/react";
import { Heading } from "@narsil-cms/blocks";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { getField } from "@narsil-cms/plugins/fields";
import type { Block, BlockElementCondition, Field, TemplateSection } from "@narsil-cms/types";
import parse from "html-react-parser";
import { Fragment } from "react";
import useForm from "./form-context";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormLanguage from "./form-language";
import FormMessage from "./form-message";

type FormRendererProps = (Block | Field | TemplateSection) & {
  className?: string;
  conditions?: BlockElementCondition[];
  width?: number;
  onChange?: (value: unknown) => void;
};

function FormRenderer({ className, conditions, width, onChange, ...props }: FormRendererProps) {
  const { data } = useForm();

  if ("elements" in props) {
    return (
      <>
        {props.elements?.map((element, index) => {
          const childElement = element.element;

          return (
            <Fragment key={index}>
              {"type" in childElement ? (
                <FormRenderer
                  {...childElement}
                  handle={element.handle ?? childElement.handle}
                  name={element.name ?? childElement.name}
                  width={element.width}
                />
              ) : (
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
                    {childElement.collapsible ? (
                      <Icon
                        className={cn("duration-300", "group-data-[state=open]:rotate-180")}
                        name="chevron-down"
                      />
                    ) : null}
                  </CollapsibleTrigger>
                  <CollapsibleContent className="grid grid-cols-12 gap-4 p-4">
                    <FormRenderer
                      {...childElement}
                      handle={element.handle ?? childElement.handle}
                      name={element.name ?? childElement.name}
                      width={element.width}
                    />
                  </CollapsibleContent>
                </CollapsibleRoot>
              )}
            </Fragment>
          );
        })}
      </>
    );
  }

  return "settings" in props ? (
    <FormField
      id={props.handle}
      conditions={conditions}
      field={props}
      render={({ fieldLanguage, placeholder, value, onFieldChange, setFieldLanguage }) => {
        function handleOnChange(value: unknown) {
          onChange?.(value);
          onFieldChange(value);
        }

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
              <div className="flex items-center gap-2">
                <FormLabel required={props.settings?.required}>{props.name}</FormLabel>
                {props.translatable ? (
                  <FormLanguage
                    triggerProps={{
                      size: "sm",
                      variant: "secondary",
                    }}
                    valueProps={{
                      asChild: true,
                      children: <span className="uppercase">{fieldLanguage}</span>,
                    }}
                    value={fieldLanguage}
                    onValueChange={setFieldLanguage}
                  />
                ) : null}
              </div>
              {props.settings?.append
                ? parse(props.settings.append, {
                    replace: (domNode) => {
                      if (domNode.name === "a") {
                        return (
                          <Link href={domNode.attribs.href} className={domNode.attribs.class}>
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
              placeholder: placeholder,
              value: value,
              setValue: handleOnChange,
            })}
            {props.description ? <FormDescription>{props.description}</FormDescription> : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  ) : "type" in props ? (
    <div className="col-span-full flex items-center justify-between">
      <span className="first-letter:uppercase">{props.name}</span>
      <span>{data?.[props.handle]}</span>
    </div>
  ) : null;
}

export default FormRenderer;
