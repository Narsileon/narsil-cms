import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { Input, InputDate } from "@narsil-cms/components/ui/input";
import { isArray } from "lodash";
import { RichTextEditor } from "@narsil-cms/components/ui/rich-text-editor";
import { Slider } from "@narsil-cms/components/ui/slider";
import { Switch } from "@narsil-cms/components/ui/switch";
import {
  SortableList,
  SortableGrid,
  SortableTable,
} from "@narsil-cms/components/ui/sortable";

import type { Field, SelectOption } from "@narsil-cms/types/forms";

type FormInputRendererProps = {
  element: Field;
  id: string;
  value: any;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
  setValue: (value: any) => void;
};

function FormInputRenderer({
  element,
  id,
  value,
  renderOption,
  setValue,
}: FormInputRendererProps) {
  switch (element.type) {
    case "Narsil\\Contracts\\Fields\\CheckboxInput":
      return (
        <Checkbox
          {...element.settings}
          id={id}
          name={id}
          checked={value}
          onCheckedChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\DateInput":
      return (
        <InputDate
          {...element.settings}
          id={id}
          name={id}
          className="appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none"
          value={value}
          onChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\FileInput":
      return (
        <Input
          {...element.settings}
          id={id}
          name={id}
          onChange={(event) => setValue(event.target.files?.[0])}
        />
      );
    case "Narsil\\Contracts\\Fields\\RangeInput":
      return (
        <Slider
          {...element.settings}
          id={id}
          name={id}
          value={isArray(value) ? value : [value]}
          onValueChange={([value]) => setValue(value)}
        />
      );
    case "Narsil\\Contracts\\Fields\\RelationsInput":
      return element.settings.intermediate ? (
        <SortableGrid
          {...element.settings}
          items={value ?? []}
          setItems={setValue}
        />
      ) : (
        <SortableList
          {...element.settings}
          items={value ?? []}
          options={element.settings.options}
          setItems={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\RichTextInput":
      return (
        <RichTextEditor
          {...element.settings}
          id={id}
          value={value}
          onValueChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\SelectInput":
      return (
        <Combobox
          {...element.settings}
          id={id}
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
          name={id}
          checked={value}
          onCheckedChange={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\TableInput":
      return (
        <SortableTable
          {...element.settings}
          columns={element.settings.columns}
          rows={value ?? []}
          setRows={setValue}
        />
      );
    case "Narsil\\Contracts\\Fields\\TimeInput":
      return (
        <Input
          {...element.settings}
          id={id}
          name={id}
          className="appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none"
          value={value}
          onChange={(event) => setValue(event.target.value)}
        />
      );
    default:
      return (
        <Input
          {...element.settings}
          id={id}
          name={id}
          value={value}
          onChange={(event) => setValue(event.target.value)}
        />
      );
  }
}

export default FormInputRenderer;
