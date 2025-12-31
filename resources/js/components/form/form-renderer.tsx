import { Link } from "@inertiajs/react";
import { Button, Heading } from "@narsil-cms/blocks";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { getField } from "@narsil-cms/repositories/fields";
import type { Block, Condition, Field, TemplateTab } from "@narsil-cms/types";
import parse from "html-react-parser";
import { get, kebabCase } from "lodash-es";
import { Fragment } from "react";
import useForm from "./form-context";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormFieldLanguage from "./form-field-language";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";

type FormRendererProps = (Block | Field | TemplateTab) & {
  className?: string;
  conditions?: Condition[];
  required?: boolean;
  translatable?: boolean;
  width?: number;
  onChange?: (value: unknown) => void;
};

function FormRenderer({ className, conditions, width, onChange, ...props }: FormRendererProps) {
  const { data } = useForm();
  const { trans } = useLocalization();

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
                  conditions={element.conditions}
                  handle={element.handle ?? childElement.handle}
                  name={element.name ?? childElement.name}
                  required={element.required ?? childElement.required}
                  translatable={element.translatable ?? childElement.translatable}
                  width={element.width}
                />
              ) : (
                <CollapsibleRoot
                  className={cn(
                    "group col-span-full not-first:border-t",
                    "first:-mt-4",
                    "-mb-4",
                    "data-[state=closed]:not-last:border-b",
                  )}
                  disabled={!childElement.collapsible}
                  defaultOpen={true}
                >
                  <CollapsibleTrigger
                    className={cn(
                      "flex w-full items-center justify-between py-4 text-center",
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
                  <CollapsibleContent className="grid grid-cols-12 gap-8 py-4">
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

  if (!("settings" in props)) {
    return null;
  }

  const { description, required, settings, translatable, type } = props as {
    description?: string;
    required?: boolean;
    translatable?: boolean;
    type: Field["type"];
    settings: {
      append?: string;
      className?: string;
      generate?: string;
      type?: string;
    };
  };

  return (
    <FormField
      id={props.handle}
      conditions={conditions}
      field={props as Field}
      render={({ fieldLanguage, placeholder, value, onFieldChange, setFieldLanguage }) => {
        function handleOnChange(value: unknown) {
          onChange?.(value);
          onFieldChange(value);
        }
        console.log(placeholder, props);
        return (
          <FormItem
            className={cn(
              settings.type === "hidden" && "hidden",
              props.class_name ?? "",
              className,
            )}
            width={width}
          >
            <div className="flex items-center justify-between gap-3">
              <div className="flex items-center gap-1">
                <FormLabel required={required}>{props.name}</FormLabel>
                {translatable ? (
                  <>
                    <Icon className="size-4" name="globe" />
                    <span>-</span>
                    <FormFieldLanguage
                      triggerProps={{
                        size: "sm",
                        variant: "inline",
                      }}
                      valueProps={{
                        asChild: true,
                        children: <span className="uppercase">{fieldLanguage}</span>,
                      }}
                      value={fieldLanguage}
                      onValueChange={setFieldLanguage}
                    />
                  </>
                ) : null}
              </div>
              {settings.generate ? (
                <Button
                  className="text-foreground/70"
                  iconProps={{
                    className: "text-foreground/70",
                    name: "refresh",
                  }}
                  size="sm"
                  variant="ghost"
                  onClick={() => {
                    let original = get(data, `${settings.generate}.${fieldLanguage}`) as string;

                    if (!original) {
                      original = get(data, `${settings.generate}`, "") as string;
                    }

                    handleOnChange?.(kebabCase(original));
                  }}
                >
                  {trans("ui.generate")}
                </Button>
              ) : null}
              {settings?.append
                ? parse(settings.append, {
                    replace: (domNode) => {
                      if (domNode.type === "tag" && domNode.name === "a") {
                        return (
                          <Link href={domNode.attribs.href} className={domNode.attribs.class}>
                            {domNode.children
                              .map((child) => ("data" in child ? child.data : ""))
                              .join("")}
                          </Link>
                        );
                      }
                    },
                  })
                : null}
            </div>
            {getField(type, {
              id: props.handle,
              element: props as Field,
              placeholder: placeholder ?? props.placeholder,
              required: required,
              value: value,
              setValue: handleOnChange,
            })}
            {props.description ? <FormDescription>{description}</FormDescription> : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  );
}

export default FormRenderer;
