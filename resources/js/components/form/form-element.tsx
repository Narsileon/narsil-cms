import { Link } from "@inertiajs/react";
import { Button } from "@narsil-cms/blocks/button";
import { Heading } from "@narsil-cms/blocks/heading";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { getField } from "@narsil-cms/repositories/fields";
import type { StructureHasElement } from "@narsil-cms/types";
import parse from "html-react-parser";
import { get, kebabCase } from "lodash-es";
import useForm from "./form-context";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormFieldLanguage from "./form-field-language";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";

type FormElementProps = StructureHasElement & {
  onChange?: (value: unknown) => void;
};

function FormElement({ onChange, ...props }: FormElementProps) {
  const { class_name, description, element, handle, label, required, translatable, width } = props;

  const { data } = useForm();
  const { trans } = useLocalization();

  if ("elements" in element) {
    return (
      <CollapsibleRoot
        className={cn(
          "group col-span-full not-first:border-t",
          "first:-mt-4",
          "-mb-4",
          "data-[state=closed]:not-last:border-b",
        )}
        disabled={!element.collapsible}
        defaultOpen={true}
      >
        <CollapsibleTrigger
          className={cn(
            "flex w-full items-center justify-between py-4 text-center",
            "data-[state=open]:border-b",
          )}
        >
          <Heading level="h2">{label}</Heading>
          {element.collapsible ? (
            <Icon
              className={cn("duration-300", "group-data-[state=open]:rotate-180")}
              name="chevron-down"
            />
          ) : null}
        </CollapsibleTrigger>
        <CollapsibleContent className="grid grid-cols-12 gap-8 py-4">
          {element.elements.map((childElement, index) => {
            const virtualHandle =
              element.virtual === false ? `${handle}.${childElement.handle}` : childElement.handle;
            return <FormElement {...childElement} handle={virtualHandle} key={index} />;
          })}
        </CollapsibleContent>
      </CollapsibleRoot>
    );
  }

  return (
    <FormField
      {...props}
      render={({ fieldLanguage, placeholder, value, onFieldChange, setFieldLanguage }) => {
        function handleOnChange(value: unknown) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FormItem
            className={cn(element.settings.type === "hidden" && "hidden", class_name)}
            width={width}
          >
            <div className="flex items-center justify-between gap-3">
              <div className="flex items-center gap-1">
                <FormLabel required={required}>{props.label}</FormLabel>
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
              {element.settings.generate ? (
                <Button
                  className="text-muted-foreground"
                  iconProps={{
                    className: "text-muted-foreground",
                    name: "refresh",
                  }}
                  size="sm"
                  variant="ghost"
                  onClick={() => {
                    let original = get(
                      data,
                      `${element.settings.generate}.${fieldLanguage}`,
                    ) as string;

                    if (!original) {
                      original = get(data, `${element.settings.generate}`, "") as string;
                    }

                    handleOnChange?.(kebabCase(original));
                  }}
                >
                  {trans("ui.generate")}
                </Button>
              ) : null}
              {"append" in element.settings
                ? parse(element.settings.append, {
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
            {description ? <FormDescription>{description}</FormDescription> : null}
            {getField(element.type, {
              id: handle,
              field: {
                ...element,
                placeholder: placeholder as string,
              },
              required: required,
              value: value,
              setValue: handleOnChange,
            })}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  );
}

export default FormElement;
