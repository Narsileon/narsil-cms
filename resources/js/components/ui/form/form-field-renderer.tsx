import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { Heading } from "@narsil-cms/components/ui/heading";
import { Input } from "@narsil-cms/components/ui/input";
import { isArray } from "lodash";
import { Slider } from "@narsil-cms/components/ui/slider";
import { Sortable } from "@narsil-cms/components/ui/sortable";
import { Switch } from "@narsil-cms/components/ui/switch";
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
            {element.type === "Narsil\\Contracts\\Fields\\CheckboxInput" ? (
              <Checkbox
                {...settings}
                id={element.handle}
                name={element.handle}
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
              />
            ) : element.type === "Narsil\\Contracts\\Fields\\SelectInput" ? (
              <Combobox
                {...settings}
                id={element.handle}
                options={settings.options}
                renderOption={renderOption}
                value={value}
                setValue={(value) => handleOnChange(value)}
              />
            ) : element.type === "Narsil\\Contracts\\Fields\\RangeInput" ? (
              <Slider
                {...settings}
                id={element.handle}
                name={element.handle}
                value={isArray(value) ? value : [value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : element.type === "Narsil\\Contracts\\Fields\\RelationsInput" ? (
              <Sortable
                {...settings}
                initialOptions={settings.options}
                items={value ?? []}
                setItems={(value) => handleOnChange(value)}
              />
            ) : element.type === "Narsil\\Contracts\\Fields\\SwitchInput" ? (
              <Switch
                {...settings}
                name={element.handle}
                checked={value}
                onCheckedChange={(value) => handleOnChange(value)}
              />
            ) : (
              <Input
                {...settings}
                id={element.handle}
                name={element.handle}
                value={value}
                onChange={(event) => handleOnChange(event.target.value)}
              />
            )}
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
