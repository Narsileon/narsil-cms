import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { Input } from "@narsil-cms/components/ui/input";
import { isArray } from "lodash";
import { Slider } from "@narsil-cms/components/ui/slider";
import { SortableTable } from "@narsil-cms/components/ui/sortable";
import { Switch } from "@narsil-cms/components/ui/switch";
import type { Field, SelectOption } from "@narsil-cms/types/forms";

type FormInputRendererProps = {
  element: Field;
  value: any;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
  setValue: (value: any) => void;
};

function FormInputRenderer({
  element,
  value,
  renderOption,
  setValue,
}: FormInputRendererProps) {
  switch (element.type) {
    case "Narsil\\Contracts\\Fields\\CheckboxInput":
      return (
        <Checkbox
          {...element.settings}
          id={element.handle}
          name={element.handle}
          checked={value}
          onCheckedChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\RangeInput":
      return (
        <Slider
          {...element.settings}
          id={element.handle}
          name={element.handle}
          value={isArray(value) ? value : [value]}
          onValueChange={([value]) => setValue(value)}
        />
      );
    case "Narsil\\Contracts\\Fields\\SelectInput":
      return (
        <Combobox
          {...element.settings}
          id={element.handle}
          options={element.settings.options}
          renderOption={renderOption}
          value={value}
          setValue={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\SwitchInput":
      return (
        <Switch
          {...element.settings}
          name={element.handle}
          checked={value}
          onCheckedChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\TableInput":
      return (
        <SortableTable
          {...element.settings}
          columns={element.settings.columns}
          items={value ?? []}
          setItems={setValue}
        />
      );
    default:
      return (
        <Input
          {...element.settings}
          id={element.handle}
          name={element.handle}
          value={value}
          onChange={(event) => setValue(event.target.value)}
        />
      );
  }
}

export default FormInputRenderer;
