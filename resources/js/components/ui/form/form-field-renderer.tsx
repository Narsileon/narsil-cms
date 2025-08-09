import { cn } from "@narsil-cms/lib/utils";
import { Heading } from "@narsil-cms/components/ui/heading";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormInputRenderer from "./form-input-renderer";
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
  renderOption,
}: FormFieldRendererProps) {
  const { data } = useForm();

  const finalHandle = handle ?? element.handle;
  const finalName = name ?? element.name;

  if ("elements" in element) {
    return (
      <>
        {finalName ? (
          <Heading className="text-lg font-semibold" level="h2">
            {finalName}
          </Heading>
        ) : null}
        {element.elements.map((element, index) => {
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
    <Heading className="bg-input/25 -mx-4 border-t border-b p-4" level="h2">
      {finalName}
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
            <FormLabel required={settings.required}>{finalName}</FormLabel>
            <FormInputRenderer
              id={finalHandle}
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
