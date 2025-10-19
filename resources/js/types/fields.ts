import { Array } from "@narsil-cms/blocks/fields/array";
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
import { InputContent } from "@narsil-cms/components/input";
import { SortableGrid, SortableList, SortableTree } from "@narsil-cms/components/sortable";
import { type IconName } from "@narsil-cms/plugins/icons";
import { type ComponentProps } from "react";

type DefaultField = {
  type: "default";
  settings: Record<string, unknown> & {
    icon?: IconName;
  };
};

type ArrayField = {
  type: "Narsil\\Contracts\\Fields\\ArrayField";
  settings: ComponentProps<typeof Array>;
};

type CheckboxField = {
  type: "Narsil\\Contracts\\Fields\\CheckboxField";
  settings: ComponentProps<typeof Checkbox> | ComponentProps<typeof Checkboxes>;
};

type DateField = {
  type: "Narsil\\Contracts\\Fields\\DateField";
  settings: ComponentProps<typeof Datetime>;
};

type FileField = {
  type: "Narsil\\Contracts\\Fields\\FileField";
  settings: ComponentProps<typeof File> & {
    icon?: IconName;
  };
};

type PasswordField = {
  type: "Narsil\\Contracts\\Fields\\PasswordField";
  settings: ComponentProps<typeof Password>;
};

type RangeField = {
  type: "Narsil\\Contracts\\Fields\\RangeField";
  settings: ComponentProps<typeof Slider>;
};

type RelationsField = {
  type: "Narsil\\Contracts\\Fields\\RelationsField";
  settings:
    | ComponentProps<typeof SortableGrid>
    | ComponentProps<typeof SortableList>
    | ComponentProps<typeof Relations>;
};

type RichTextField = {
  type: "Narsil\\Contracts\\Fields\\RichTextField";
  settings: ComponentProps<typeof RichTextEditor>;
};

type SelectField = {
  type: "Narsil\\Contracts\\Fields\\SelectField";
  settings: ComponentProps<typeof Combobox>;
};

type SwitchField = {
  type: "Narsil\\Contracts\\Fields\\SwitchField";
  settings: ComponentProps<typeof Switch>;
};

type TableField = {
  type: "Narsil\\Contracts\\Fields\\TableField";
  settings: ComponentProps<typeof Table>;
};

type TimeField = {
  type: "Narsil\\Contracts\\Fields\\TimeField";
  settings: ComponentProps<typeof InputContent> & { icon?: string };
};

type TreeField = {
  type: "Narsil\\Contracts\\Fields\\TreeField";
  settings: ComponentProps<typeof SortableTree> & { icon?: string };
};

export type FieldType =
  | DefaultField
  | ArrayField
  | CheckboxField
  | DateField
  | FileField
  | PasswordField
  | RangeField
  | RelationsField
  | RichTextField
  | SelectField
  | SwitchField
  | TableField
  | TimeField
  | TreeField;
