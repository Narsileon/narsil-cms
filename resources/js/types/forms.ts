import { RouteNames } from "./collection";
import type { IconName } from "@narsil-cms/plugins/icons";

export type Block = {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
  sets: Block[];
};

export type HasElement = {
  element_id: number;
  element_type:
    | "Narsil\\Models\\Elements\\Block"
    | "Narsil\\Models\\Elements\\Field";
  element: Block | Field;
  handle: string;
  id: number;
  name: string;
  position: number;
  width: number;
};

export type BlockElementCondition = {
  id: number;
  operator: string;
  owner_id: number;
  target_id: number;
  value: string;
};

export type Field = {
  blocks: Block[];
  description: string | null;
  handle: string;
  id: number;
  name: string;
  settings: {
    [key: string]: any;
    relation?: Field;
    options?: GroupedSelectOption[] | SelectOption[];
    label: string;
    value: any;
  };
  type: string;
};

export type FormType = {
  action: string;
  description: string;
  form: (Block | Field)[];
  id: string;
  method: string;
  routes: RouteNames;
  submitIcon?: IconName;
  submitLabel: string;
  title: string;
};

export type GroupedSelectOption = {
  [key: string]: any;
  icon?: IconName;
  identifier: string;
  label: string;
  optionLabel: string;
  options: (GroupedSelectOption | SelectOption)[];
  optionValue: string;
  routes: RouteNames;
  value: any;
};

export type SelectOption = {
  [key: string]: any;
  icon?: IconName;
  label: string;
  value: any;
};
