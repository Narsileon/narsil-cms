import { Array } from "@narsil-cms/blocks/fields/array";
import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Checkboxes } from "@narsil-cms/blocks/fields/checkboxes";
import { Combobox } from "@narsil-cms/blocks/fields/combobox";
import { Date } from "@narsil-cms/blocks/fields/date";
import { Datetime } from "@narsil-cms/blocks/fields/datetime";
import { File } from "@narsil-cms/blocks/fields/file";
import { Password } from "@narsil-cms/blocks/fields/password";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { Table } from "@narsil-cms/blocks/fields/table";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import type { Field } from "@narsil-cms/types";
import { Checkbox } from "@narsil-ui/components/checkbox";
import { Icon } from "@narsil-ui/components/icon";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@narsil-ui/components/input-group";
import { Slider } from "@narsil-ui/components/slider";
import { Switch } from "@narsil-ui/components/switch";
import { Textarea } from "@narsil-ui/components/textarea";
import { dynamic } from "@narsil-ui/lib/dynamic";
import { cn } from "@narsil-ui/lib/utils";
import { isArray } from "lodash-es";
import { type ReactNode } from "react";
import { route } from "ziggy-js";

const RichTextEditor = dynamic<any>(() =>
  import("@narsil-cms/blocks/fields/rich-text-editor").then((importer) => ({
    default: importer.RichTextEditor,
  })),
);

export type FieldProps = {
  field: Field;
  id: string;
  required?: boolean;
  value: any;
  setValue: (value: any) => void;
};

type Registry = {
  [K in FieldProps["field"]["type"]]: (
    props: FieldProps & {
      field: Extract<FieldProps["field"], { type: K }>;
    },
  ) => ReactNode;
};

const defaultRegistry: Registry = {
  ["Narsil\\Cms\\Contracts\\Fields\\ArrayField"]: (props) => {
    return (
      <Array
        {...props.field.settings}
        id={props.id}
        items={props.value ?? []}
        setItems={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\BuilderField"]: (props) => {
    return <Builder {...props.field.settings} blocks={props.field.blocks} name={props.id} />;
  },
  ["Narsil\\Cms\\Contracts\\Fields\\CheckboxField"]: (props) => {
    if (props.field.options?.length > 0) {
      return (
        <Checkboxes
          {...props.field.settings}
          options={props.field.options}
          values={isArray(props.value) ? props.value : []}
          onChange={props.setValue}
        />
      );
    } else {
      return (
        <Checkbox
          {...props.field.settings}
          id={props.id}
          name={props.id}
          checked={[true, "1", "true", 1].includes(props.value)}
          onCheckedChange={props.setValue}
          required={props.required}
        />
      );
    }
  },
  ["Narsil\\Cms\\Contracts\\Fields\\DateField"]: (props) => {
    return (
      <Date
        {...props.field.settings}
        id={props.id}
        name={props.id}
        placeholder={props.field.placeholder}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\DatetimeField"]: (props) => {
    return (
      <Datetime
        {...props.field.settings}
        id={props.id}
        name={props.id}
        placeholder={props.field.placeholder}
        required={props.required}
        value={props.value}
        onChange={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\EntityField"]: (props) => {
    return (
      <Combobox
        {...props.field.settings}
        extraQuery={{
          collections: props.field.settings.collections as number[],
        }}
        href={route("entities.search")}
        id={props.id}
        options={props.field.options}
        placeholder={props.field.placeholder}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\FileField"]: (props) => {
    return (
      <File
        {...props.field.settings}
        id={props.id}
        name={props.id}
        placeholder={props.field.placeholder}
        value={props.value}
        onChange={props.setValue}
        required={props.required}
      >
        {props.field.settings.icon ? (
          <Icon className="opacity-50" name={props.field.settings.icon} />
        ) : null}
      </File>
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\FormField"]: (props) => {
    return (
      <Combobox
        {...props.field.settings}
        href={route("forms.search")}
        id={props.id}
        options={props.field.options}
        placeholder={props.field.placeholder}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\LinkField"]: (props) => {
    return (
      <Combobox
        {...props.field.settings}
        href={route("site-pages.search")}
        id={props.id}
        options={props.field.options}
        placeholder={props.field.placeholder}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\PasswordField"]: (props) => {
    return (
      <Password
        {...props.field.settings}
        id={props.id}
        name={props.id}
        placeholder={props.field.placeholder}
        required={props.required}
        value={props.value}
        onChange={(event) => props.setValue(event.target.value)}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\RangeField"]: (props) => {
    return (
      <Slider
        {...props.field.settings}
        id={props.id}
        name={props.id}
        value={isArray(props.value) ? props.value : [props.value]}
        onValueChange={(value) => props.setValue(value)}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\RelationsField"]: (props) => {
    if ("intermediate" in props.field.settings) {
      return (
        <SortableGrid
          {...props.field.settings}
          items={props.value ?? []}
          placeholder={props.field.placeholder as string}
          setItems={props.setValue}
        />
      );
    } else if ("options" in props.field.settings) {
      return (
        <SortableList
          {...props.field.settings}
          items={props.value ?? []}
          setItems={props.setValue}
        />
      );
    } else {
      return (
        <Relations
          {...props.field.settings}
          id={props.id}
          placeholder={props.field.placeholder}
          value={props.value}
          setValue={props.setValue}
        />
      );
    }
  },
  ["Narsil\\Cms\\Contracts\\Fields\\RichTextField"]: (props) => {
    return (
      <RichTextEditor
        {...props.field.settings}
        id={props.id}
        placeholder={props.field.placeholder}
        value={props.value}
        onChange={props.setValue}
        required={props.required}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\SelectField"]: (props) => {
    return (
      <Combobox
        {...props.field.settings}
        id={props.id}
        options={props.field.options}
        placeholder={props.field.placeholder}
        value={props.value}
        setValue={props.setValue}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\SwitchField"]: (props) => {
    return (
      <Switch
        {...props.field.settings}
        name={props.id}
        checked={props.value}
        onCheckedChange={props.setValue}
        required={props.required}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\TableField"]: (props) => {
    return <Table {...props.field.settings} rows={props.value ?? []} setRows={props.setValue} />;
  },
  ["Narsil\\Cms\\Contracts\\Fields\\TextareaField"]: (props) => {
    return (
      <Textarea
        {...props.field.settings}
        name={props.id}
        placeholder={props.field.placeholder}
        value={props.value}
        onChange={(event) => props.setValue(event.target.value)}
        required={props.required}
      />
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\TimeField"]: (props) => {
    return (
      <InputGroup>
        <InputGroupInput
          {...props.field.settings}
          id={props.id}
          name={props.id}
          className={cn(
            !props.value && "opacity-50",
            "[&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none",
          )}
          placeholder={props.field.placeholder}
          required={props.required}
          value={props.value}
          onChange={(event) => props.setValue(event.target.value)}
        />
        <InputGroupAddon align="inline-end">
          <Icon className="opacity-50" name="clock" />
        </InputGroupAddon>
      </InputGroup>
    );
  },
  ["Narsil\\Cms\\Contracts\\Fields\\TreeField"]: (props) => {
    return <Tree {...props.field.settings} items={props.value ?? []} setItems={props.setValue} />;
  },
  ["default"]: (props) => {
    return (
      <InputGroup>
        <InputGroupInput
          {...props.field.settings}
          id={props.id}
          name={props.id}
          placeholder={props.field.placeholder}
          value={props.value}
          onChange={(event) => props.setValue(event.target.value)}
          required={props.required}
        />
        {props.field.settings.icon ? (
          <InputGroupAddon align="inline-end">
            <Icon className="opacity-50" name={props.field.settings.icon} />
          </InputGroupAddon>
        ) : null}
      </InputGroup>
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
