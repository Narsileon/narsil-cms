import { cn } from "@narsil-cms/lib/utils";
import { Heading } from "@narsil-cms/components/ui/heading";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";
import useForm from "./form-context";
import type {
  Block,
  BlockElementCondition,
  Field,
  SelectOption,
} from "@narsil-cms/types/forms";
import FormInputRenderer from "./form-input-renderer";

type FormFieldRendererProps = {
  className?: string;
  conditions?: BlockElementCondition[];
  element: Field | Block;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormFieldRenderer({
  className,
  conditions,
  element,
  onChange,
  renderOption,
}: FormFieldRendererProps) {
  const { data } = useForm();

  if ("elements" in element) {
    return (
      <>
        {element.name ? (
          <Heading className="text-lg font-semibold" level="h2">
            {element.name}
          </Heading>
        ) : null}
        {element.elements.map((element, index) => {
          return (
            <FormFieldRenderer
              conditions={element.conditions}
              element={element.element}
              key={index}
            />
          );
        })}
      </>
    );
  }

  const settings = element.settings ?? {};

  if (!element.type) {
    return (
      <div className="col-span-full flex items-center justify-between text-sm">
        <span>{element.name}</span>
        <span>{data?.[element.handle]}</span>
      </div>
    );
  }

  return element.type === "Narsil\\Contracts\\Fields\\SectionElement" ? (
    <Heading className="bg-accent/50 -mx-4 p-4" level="h2">
      {element.name}
    </Heading>
  ) : (
    <FormField
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
              settings.type === "checkbox" && "flex-row-reverse justify-end",
              settings.className,
              className,
            )}
          >
            <FormLabel required={settings.required}>{element.name}</FormLabel>
            <FormInputRenderer
              element={element}
              value={value}
              renderOption={renderOption}
              setValue={handleOnChange}
            />
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
