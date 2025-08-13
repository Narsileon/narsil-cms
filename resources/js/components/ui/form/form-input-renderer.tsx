import { Checkbox, Checkboxes } from "@narsil-cms/components/ui/checkbox";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { isArray } from "lodash";
import { RichTextEditor } from "@narsil-cms/components/ui/rich-text-editor";
import { Slider } from "@narsil-cms/components/ui/slider";
import { Switch } from "@narsil-cms/components/ui/switch";
import {
  Input,
  InputDate,
  InputFile,
  InputPassword,
} from "@narsil-cms/components/ui/input";
import {
  SortableList,
  SortableGrid,
  SortableTable,
} from "@narsil-cms/components/ui/sortable";

import type {
  Field,
  GroupedSelectOption,
  SelectOption,
} from "@narsil-cms/types/forms";
import { Icon } from "../icon";

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
      return element.settings.options ? (
        <Checkboxes
          {...element.settings}
          options={element.settings.options as GroupedSelectOption[]}
          values={isArray(value) ? value : []}
          setValues={setValue}
        />
      ) : (
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
        <InputFile
          {...element.settings}
          id={id}
          name={id}
          value={value}
          setValue={setValue}
        >
          {element.settings.icon ? (
            <Icon className="opacity-50" name={element.settings.icon} />
          ) : null}
        </InputFile>
      );
    case "Narsil\\Contracts\\Fields\\PasswordInput":
      return (
        <InputPassword
          {...element.settings}
          id={id}
          name={id}
          value={value}
          onChange={(event) => setValue(event.target.value)}
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
        >
          {element.settings.icon ? (
            <Icon className="opacity-50" name={element.settings.icon} />
          ) : null}
        </Input>
      );
  }
}

export default FormInputRenderer;
