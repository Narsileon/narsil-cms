import { ComponentProps } from "react";

import {
  Array,
  Checkbox,
  Checkboxes,
  Combobox,
  InputDate,
  InputFile,
  InputPassword,
  Relations,
  RichTextEditor,
  Slider,
  Switch,
  Table,
} from "@narsil-cms/blocks/fields";
import { InputContent } from "@narsil-cms/components/input";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import { IconName } from "@narsil-cms/plugins/icons";

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
  settings: ComponentProps<typeof InputDate>;
};

type FileField = {
  type: "Narsil\\Contracts\\Fields\\FileField";
  settings: ComponentProps<typeof InputFile> & {
    icon?: IconName;
  };
};

type PasswordField = {
  type: "Narsil\\Contracts\\Fields\\PasswordField";
  settings: ComponentProps<typeof InputPassword>;
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
  | TimeField;
