import { Link } from "@inertiajs/react";
import { getField } from "@narsil-cms/registries/fields";
import type { Element } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-ui/components/collapsible";
import { FieldDescription, FieldError, FieldLabel, FieldRoot } from "@narsil-ui/components/field";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import parse from "html-react-parser";
import { get, kebabCase } from "lodash-es";
import useForm from "./form-context";
import FormField from "./form-field";
import FormFieldLanguage from "./form-field-language";

type FormElementProps = Element & {
  onChange?: (value: unknown) => void;
};

function FormElement({ onChange, ...props }: FormElementProps) {
  const { base, class_name, description, handle, label, required, translatable, width } = props;

  const { data } = useForm();
  const { trans } = useTranslator();

  if ("elements" in base) {
    return (
      <CollapsibleRoot
        className={cn("group col-span-full rounded border")}
        disabled={!base.collapsible}
        defaultOpen={true}
      >
        <CollapsibleTrigger
          className={cn(
            "flex w-full items-center justify-between bg-muted px-4 py-2 text-center text-muted-foreground",
          )}
        >
          <Heading level="h2">{label}</Heading>
          {base.collapsible ? (
            <Icon
              className={cn("duration-300", "group-data-[state=open]:rotate-180")}
              name="chevron-down"
            />
          ) : null}
        </CollapsibleTrigger>
        <CollapsiblePanel className="grid grid-cols-12 gap-8 p-4">
          {base.elements.map((element, index) => {
            const virtualHandle =
              base.virtual === false ? `${handle}.${element.handle}` : element.handle;
            return <FormElement {...element} handle={virtualHandle} key={index} />;
          })}
        </CollapsiblePanel>
      </CollapsibleRoot>
    );
  }

  return (
    <FormField
      {...props}
      render={({ error, fieldLanguage, placeholder, value, onFieldChange, setFieldLanguage }) => {
        function handleOnChange(value: unknown) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FieldRoot
            className={cn(base.settings.type === "hidden" && "hidden", class_name)}
            width={width}
          >
            <div className="flex items-center justify-between gap-3">
              <div className="flex items-center gap-1">
                <FieldLabel required={required}>{props.label}</FieldLabel>
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
                        children: <span className="uppercase">{fieldLanguage}</span>,
                      }}
                      value={fieldLanguage}
                      onValueChange={setFieldLanguage}
                    />
                  </>
                ) : null}
              </div>
              {base.settings.generate ? (
                <Button
                  className="text-muted-foreground"
                  size="sm"
                  variant="ghost"
                  onClick={() => {
                    let original = get(
                      data,
                      `${base.settings.generate}.${fieldLanguage}`,
                    ) as string;

                    if (!original) {
                      original = get(data, `${base.settings.generate}`, "") as string;
                    }

                    handleOnChange?.(kebabCase(original));
                  }}
                >
                  <Icon className="text-muted-foreground" name="refresh" />
                  {trans("ui.generate")}
                </Button>
              ) : null}
              {"append" in base.settings
                ? parse(base.settings.append, {
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
            {description ? <FieldDescription>{description}</FieldDescription> : null}
            {getField(base.type, {
              id: handle,
              field: {
                ...base,
                placeholder: placeholder as string,
              },
              required: required,
              value: value,
              setValue: handleOnChange,
            })}
            <FieldError>{error}</FieldError>
          </FieldRoot>
        );
      }}
    />
  );
}

export default FormElement;
