import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { DynamicIcon } from "lucide-react/dynamic";
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
import type { Block, Field, SelectOption } from "@narsil-cms/types/forms";

type FormFieldRendererProps = {
  className?: string;
  element: Field | Block;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormFieldRenderer({
  className,
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

        {element.elements.map((element, index) => (
          <FormFieldRenderer element={element} key={index} />
        ))}
      </>
    );
  }

  const settings = element.settings ?? {};

  const { type, ...props } = settings;

  return type ? (
    <FormField
      field={element}
      render={({ value, onFieldChange }) => {
        function handleOnChange(value: any) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FormItem
            className={cn(
              type === "checkbox" && "flex-row-reverse justify-end",

              settings.className,
              className,
            )}
          >
            <FormLabel required={settings.required}>
              {element.icon ? <DynamicIcon name={element.icon} /> : null}
              {element.name}
            </FormLabel>
            {settings.type === "checkbox" ? (
              <Checkbox
                {...props}
                id={element.handle}
                name={element.handle}
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
              />
            ) : settings.type === "select" ? (
              <Combobox
                {...props}
                id={element.handle}
                options={settings.options}
                renderOption={renderOption}
                value={value}
                setValue={(value) => handleOnChange(value)}
              />
            ) : settings.type === "range" ? (
              <Slider
                {...props}
                id={element.handle}
                name={element.handle}
                value={isArray(value) ? value : [value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : settings.type === "relations" ? (
              <Sortable
                {...props}
                items={value ?? []}
                setItems={(value) => handleOnChange(value)}
              />
            ) : settings.type === "switch" ? (
              <Switch
                {...props}
                name={element.handle}
                checked={value}
                onCheckedChange={(value) => handleOnChange(value)}
              />
            ) : (
              <Input
                {...props}
                id={element.handle}
                name={element.handle}
                value={value}
                type={type}
                onChange={(e) => handleOnChange(e.target.value)}
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
  ) : (
    <div className="col-span-full flex items-center justify-between text-sm">
      <span>{element.name}</span>
      <span>{data?.[element.handle]}</span>
    </div>
  );
}

export default FormFieldRenderer;
