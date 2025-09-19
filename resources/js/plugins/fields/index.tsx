import { isArray } from "lodash";

import {
  Checkbox,
  Checkboxes,
  Combobox,
  InputDate,
  InputFile,
  InputPassword,
  RichTextEditor,
  Slider,
  Switch,
} from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import {
  SortableGrid,
  SortableList,
  SortableTable,
} from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import { type Field } from "@narsil-cms/types";

export type FieldProps = {
  element: Field;
  id: string;
  value: any;
  setValue: (value: any) => void;
};

type Registry = Record<string, React.ComponentType<FieldProps>>;

const defaultRegistry: Registry = {
  ["Narsil\\Contracts\\Fields\\CheckboxInput"]: (props) => {
    if (props.element.settings.options) {
      return (
        <Checkboxes
          {...props.element.settings}
          options={props.element.settings.options}
          values={isArray(props.value) ? props.value : []}
          onChange={props.setValue}
        />
      );
    } else {
      return (
        <Checkbox
          {...props.element.settings}
          id={props.id}
          name={props.id}
          checked={[true, "1", "true", 1].includes(props.value)}
          onCheckedChange={props.setValue}
        />
      );
    }
  },
  ["Narsil\\Contracts\\Fields\\DateInput"]: (props) => {
    return (
      <InputDate
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\FileInput"]: (props) => {
    return (
      <InputFile
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={props.setValue}
      >
        {props.element.settings.icon ? (
          <Icon className="opacity-50" name={props.element.settings.icon} />
        ) : null}
      </InputFile>
    );
  },
  ["Narsil\\Contracts\\Fields\\PasswordInput"]: (props) => {
    return (
      <InputPassword
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={(event) => props.setValue(event.target.value)}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\RangeInput"]: (props) => {
    return (
      <Slider
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={isArray(props.value) ? props.value : [props.value]}
        onValueChange={([value]) => props.setValue(value)}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\RelationsInput"]: (props) => {
    if (props.element.settings.intermediate) {
      return (
        <SortableGrid
          {...props.element.settings}
          items={props.value ?? []}
          setItems={props.setValue}
        />
      );
    } else if (props.element.settings.options) {
      return (
        <SortableList
          {...props.element.settings}
          items={props.value ?? []}
          setItems={props.setValue}
        />
      );
    } else {
      return (
        <Combobox
          {...props.element.settings}
          id={props.id}
          value={props.value}
          setValue={props.setValue}
        />
      );
    }
  },
  ["Narsil\\Contracts\\Fields\\RichTextInput"]: (props) => {
    return (
      <RichTextEditor
        {...props.element.settings}
        id={props.id}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\SelectInput"]: (props) => {
    return (
      <Combobox
        {...props.element.settings}
        id={props.id}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\SwitchInput"]: (props) => {
    return (
      <Switch
        {...props.element.settings}
        name={props.id}
        checked={props.value}
        onCheckedChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\TableInput"]: (props) => {
    return (
      <SortableTable
        {...props.element.settings}
        rows={props.value ?? []}
        setRows={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\TimeInput"]: (props) => {
    return (
      <InputRoot>
        <InputContent
          {...props.element.settings}
          id={props.id}
          name={props.id}
          className={cn(
            !props.value && "opacity-50",
            "[&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none",
          )}
          value={props.value}
          onChange={(event) => props.setValue(event.target.value)}
        />
        <Icon className="opacity-50" name="clock" />
      </InputRoot>
    );
  },
  ["default"]: (props) => {
    return (
      <InputRoot>
        <InputContent
          {...props.element.settings}
          id={props.id}
          name={props.id}
          value={props.value}
          onChange={(e) => props.setValue(e.target.value)}
        />
        {props.element.settings.icon ? (
          <Icon className="opacity-50" name={props.element.settings.icon} />
        ) : null}
      </InputRoot>
    );
  },
};

export type FieldName = keyof typeof defaultRegistry;

const registry: Registry = { ...defaultRegistry };

export function getField(name: FieldName, props: FieldProps) {
  const FieldComponent = registry[name] ?? registry.default;

  return <FieldComponent {...props} />;
}

export function setField(name: string, component: ComponentType<FieldProps>) {
  registry[name] = component;
}
