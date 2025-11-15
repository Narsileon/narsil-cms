import { Array } from "@narsil-cms/blocks/fields/array";
import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Checkbox } from "@narsil-cms/blocks/fields/checkbox";
import { Checkboxes } from "@narsil-cms/blocks/fields/checkboxes";
import { Combobox } from "@narsil-cms/blocks/fields/combobox";
import { Datetime } from "@narsil-cms/blocks/fields/datetime";
import { File } from "@narsil-cms/blocks/fields/file";
import { Password } from "@narsil-cms/blocks/fields/password";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { RichTextEditor } from "@narsil-cms/blocks/fields/rich-text-editor";
import { Slider } from "@narsil-cms/blocks/fields/slider";
import { Switch } from "@narsil-cms/blocks/fields/switch";
import { Table } from "@narsil-cms/blocks/fields/table";
import { Textarea } from "@narsil-cms/blocks/fields/textarea";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Field } from "@narsil-cms/types";
import { isArray } from "lodash";
import { type ReactNode } from "react";

export type FieldProps = {
  element: Field;
  id: string;
  placeholder?: string;
  value: any;
  setValue: (value: any) => void;
};

type Registry = {
  [K in FieldProps["element"]["type"]]: (
    props: FieldProps & {
      element: Extract<FieldProps["element"], { type: K }>;
    },
  ) => ReactNode;
};

const defaultRegistry: Registry = {
  ["Narsil\\Contracts\\Fields\\ArrayField"]: (props) => {
    return (
      <Array
        {...props.element.settings}
        id={props.id}
        items={props.value ?? []}
        setItems={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\BuilderField"]: (props) => {
    return (
      <Builder
        {...props.element.settings}
        blocks={props.element.blocks}
        name={props.id.includes(".") ? props.id : "blocks"}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\CheckboxField"]: (props) => {
    if (props.element.options?.length > 0) {
      return (
        <Checkboxes
          {...props.element.settings}
          options={props.element.options}
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
  ["Narsil\\Contracts\\Fields\\DateField"]: (props) => {
    return (
      <Datetime
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\DatetimeField"]: (props) => {
    return (
      <Datetime
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\FileField"]: (props) => {
    return (
      <File
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={props.setValue}
      >
        {props.element.settings.icon ? (
          <Icon className="opacity-50" name={props.element.settings.icon} />
        ) : null}
      </File>
    );
  },
  ["Narsil\\Contracts\\Fields\\PasswordField"]: (props) => {
    return (
      <Password
        {...props.element.settings}
        id={props.id}
        name={props.id}
        value={props.value}
        onChange={(event) => props.setValue(event.target.value)}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\RangeField"]: (props) => {
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
  ["Narsil\\Contracts\\Fields\\RelationsField"]: (props) => {
    if ("intermediate" in props.element.settings) {
      return (
        <SortableGrid
          {...props.element.settings}
          items={props.value ?? []}
          setItems={props.setValue}
        />
      );
    } else if ("options" in props.element.settings) {
      return (
        <SortableList
          {...props.element.settings}
          items={props.value ?? []}
          setItems={props.setValue}
        />
      );
    } else {
      return (
        <Relations
          {...props.element.settings}
          id={props.id}
          value={props.value}
          setValue={props.setValue}
        />
      );
    }
  },
  ["Narsil\\Contracts\\Fields\\RichTextField"]: (props) => {
    return (
      <RichTextEditor
        {...props.element.settings}
        id={props.id}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\SelectField"]: (props) => {
    return (
      <Combobox
        {...props.element.settings}
        id={props.id}
        options={props.element.options}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\SwitchField"]: (props) => {
    return (
      <Switch
        {...props.element.settings}
        name={props.id}
        checked={props.value}
        onCheckedChange={props.setValue}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\TableField"]: (props) => {
    return <Table {...props.element.settings} rows={props.value ?? []} setRows={props.setValue} />;
  },
  ["Narsil\\Contracts\\Fields\\TextareaField"]: (props) => {
    return (
      <Textarea
        {...props.element.settings}
        name={props.id}
        value={props.value}
        onChange={(event) => props.setValue(event.target.value)}
      />
    );
  },
  ["Narsil\\Contracts\\Fields\\TimeField"]: (props) => {
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
  ["Narsil\\Contracts\\Fields\\TreeField"]: (props) => {
    return <Tree {...props.element.settings} items={props.value ?? []} setItems={props.setValue} />;
  },
  ["default"]: (props) => {
    return (
      <InputRoot readOnly={props.element.settings.readOnly}>
        <InputContent
          {...props.element.settings}
          id={props.id}
          name={props.id}
          placeholder={props.placeholder}
          value={props.value}
          onChange={(event) => props.setValue(event.target.value)}
        />
        {props.element.settings.icon ? (
          <Icon className="opacity-50" name={props.element.settings.icon} />
        ) : null}
      </InputRoot>
    );
  },
};

type FieldName = keyof typeof defaultRegistry;

const registry: Registry = { ...defaultRegistry };

function getField<K extends keyof Registry>(name: K, props: FieldProps) {
  const FieldComponent = registry[name] ?? registry.default;

  return <FieldComponent {...props} />;
}

function setField<K extends keyof Registry>(name: K, component: Registry[K]) {
  registry[name] = component;
}

export { getField, setField };

export type { FieldName };
