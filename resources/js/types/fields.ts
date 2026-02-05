import { Array } from "@narsil-cms/blocks/fields/array";
import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Checkboxes } from "@narsil-cms/blocks/fields/checkboxes";
import { Combobox } from "@narsil-cms/blocks/fields/combobox";
import { Datetime } from "@narsil-cms/blocks/fields/datetime";
import { File } from "@narsil-cms/blocks/fields/file";
import { Password } from "@narsil-cms/blocks/fields/password";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { RichTextEditor } from "@narsil-cms/blocks/fields/rich-text-editor";
import { Slider } from "@narsil-cms/blocks/fields/slider";
import { Table } from "@narsil-cms/blocks/fields/table";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import { type IconName } from "@narsil-cms/registries/icons";
import { Checkbox } from "@narsil-ui/components/checkbox";
import { InputContent } from "@narsil-ui/components/input";
import { Switch } from "@narsil-ui/components/switch";
import { Textarea } from "@narsil-ui/components/textarea";
import { type ComponentProps } from "react";

type DefaultField = {
  type: "default";
  settings: Record<string, unknown> & {
    icon?: IconName;
    readOnly?: boolean;
  };
};

type ArrayField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\ArrayField";
  settings: ComponentProps<typeof Array>;
};
type BuilderField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\BuilderField";
  settings: ComponentProps<typeof Builder>;
};
type CheckboxField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\CheckboxField";
  settings: ComponentProps<typeof Checkbox> | ComponentProps<typeof Checkboxes>;
};
type DateField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\DateField";
  settings: ComponentProps<typeof Datetime>;
};
type DatetimeField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\DatetimeField";
  settings: ComponentProps<typeof Datetime>;
};
type EntityField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\EntityField";
  settings: ComponentProps<typeof Combobox>;
};
type FileField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\FileField";
  settings: ComponentProps<typeof File> & {
    icon?: IconName;
  };
};
type FormField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\FormField";
  settings: ComponentProps<typeof Combobox>;
};
type LinkField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\LinkField";
  settings: ComponentProps<typeof Combobox>;
};
type PasswordField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\PasswordField";
  settings: ComponentProps<typeof Password>;
};
type RangeField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\RangeField";
  settings: ComponentProps<typeof Slider>;
};
type RelationsField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\RelationsField";
  settings:
    | ComponentProps<typeof SortableGrid>
    | ComponentProps<typeof SortableList>
    | ComponentProps<typeof Relations>;
};
type RichTextField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\RichTextField";
  settings: ComponentProps<typeof RichTextEditor>;
};
type SelectField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\SelectField";
  settings: ComponentProps<typeof Combobox>;
};
type SwitchField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\SwitchField";
  settings: ComponentProps<typeof Switch>;
};
type TableField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\TableField";
  settings: ComponentProps<typeof Table>;
};
type TextareaField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\TextareaField";
  settings: ComponentProps<typeof Textarea>;
};
type TimeField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\TimeField";
  settings: ComponentProps<typeof InputContent> & { icon?: string };
};
type TreeField = {
  type: "Narsil\\Cms\\Contracts\\Fields\\TreeField";
  settings: ComponentProps<typeof Tree> & { icon?: string };
};

export type FieldType =
  | DefaultField
  | ArrayField
  | BuilderField
  | CheckboxField
  | DateField
  | DatetimeField
  | EntityField
  | FileField
  | FormField
  | LinkField
  | PasswordField
  | RangeField
  | RelationsField
  | RichTextField
  | SelectField
  | SwitchField
  | TableField
  | TextareaField
  | TimeField
  | TreeField;
