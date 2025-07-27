import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { DynamicIcon } from "lucide-react/dynamic";
import { Heading } from "@narsil-cms/components/ui/heading";
import { Input } from "@narsil-cms/components/ui/input";
import { isArray } from "lodash";
import { Slider } from "@narsil-cms/components/ui/slider";
import { Switch } from "@narsil-cms/components/ui/switch";
import FormDescription from "./form-description";
import FormField from "./form-field";
import FormItem from "./form-item";
import FormLabel from "./form-label";
import FormMessage from "./form-message";
import type { FieldType, SelectOption } from "@narsil-cms/types/forms";
import useForm from "./form-context";

type FormFieldRendererProps = {
  className?: string;
  field: FieldType;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormFieldRenderer({
  className,
  field,
  onChange,
  renderOption,
}: FormFieldRendererProps) {
  const { data } = useForm();

  if (field.fields?.length) {
    return (
      <>
        {field.name ? (
          <Heading className="text-lg font-semibold" level="h2">
            {field.name}
          </Heading>
        ) : null}

        {field.fields.map((field, index) => (
          <FormFieldRenderer field={field} key={index} />
        ))}
      </>
    );
  }

  const settings = field.settings ?? {};

  const { type, ...props } = settings;

  return type ? (
    <FormField
      field={field}
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
            width={field.width}
          >
            <FormLabel required={settings.required}>
              {field.icon ? <DynamicIcon name={field.icon} /> : null}
              {field.name}
            </FormLabel>
            {settings.type === "checkbox" ? (
              <Checkbox
                {...props}
                id={field.handle}
                name={field.handle}
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
              />
            ) : settings.type === "select" ? (
              <Combobox
                {...props}
                id={field.handle}
                options={settings.options}
                renderOption={renderOption}
                value={value}
                setValue={(value) => handleOnChange(value)}
              />
            ) : settings.type === "range" ? (
              <Slider
                {...props}
                id={field.handle}
                name={field.handle}
                value={isArray(value) ? value : [value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : settings.type === "switch" ? (
              <Switch
                {...props}
                name={field.handle}
                checked={value}
                onCheckedChange={(value) => handleOnChange(value)}
              />
            ) : (
              <Input
                {...props}
                id={field.handle}
                name={field.handle}
                value={value}
                type={type}
                onChange={(e) => handleOnChange(e.target.value)}
              />
            )}
            {field.description ? (
              <FormDescription>{field.description}</FormDescription>
            ) : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  ) : (
    <div className="col-span-full flex items-center justify-between">
      <span>{field.name}</span>
      <span>{data?.[field.handle]}</span>
    </div>
  );
}

export default FormFieldRenderer;
