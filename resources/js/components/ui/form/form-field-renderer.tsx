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
import useForm from "./form-context";
import type {
  FieldSetType,
  FieldType,
  SelectOption,
} from "@narsil-cms/types/forms";

type FormFieldRendererProps = {
  className?: string;
  item: FieldType | FieldSetType;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormFieldRenderer({
  className,
  item,
  onChange,
  renderOption,
}: FormFieldRendererProps) {
  const { data } = useForm();

  if ("items" in item) {
    return (
      <>
        {item.name ? (
          <Heading className="text-lg font-semibold" level="h2">
            {item.name}
          </Heading>
        ) : null}

        {item.items.map((item, index) => (
          <FormFieldRenderer item={item} key={index} />
        ))}
      </>
    );
  }

  const settings = item.settings ?? {};

  const { type, ...props } = settings;

  return type ? (
    <FormField
      field={item}
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
            width={item.width}
          >
            <FormLabel required={settings.required}>
              {item.icon ? <DynamicIcon name={item.icon} /> : null}
              {item.name}
            </FormLabel>
            {settings.type === "checkbox" ? (
              <Checkbox
                {...props}
                id={item.handle}
                name={item.handle}
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
              />
            ) : settings.type === "select" ? (
              <Combobox
                {...props}
                id={item.handle}
                options={settings.options}
                renderOption={renderOption}
                value={value}
                setValue={(value) => handleOnChange(value)}
              />
            ) : settings.type === "range" ? (
              <Slider
                {...props}
                id={item.handle}
                name={item.handle}
                value={isArray(value) ? value : [value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : settings.type === "switch" ? (
              <Switch
                {...props}
                name={item.handle}
                checked={value}
                onCheckedChange={(value) => handleOnChange(value)}
              />
            ) : (
              <Input
                {...props}
                id={item.handle}
                name={item.handle}
                value={value}
                type={type}
                onChange={(e) => handleOnChange(e.target.value)}
              />
            )}
            {item.description ? (
              <FormDescription>{item.description}</FormDescription>
            ) : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  ) : (
    <div className="col-span-full flex items-center justify-between">
      <span>{item.name}</span>
      <span>{data?.[item.handle]}</span>
    </div>
  );
}

export default FormFieldRenderer;
