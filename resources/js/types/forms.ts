import { RouteNames } from "./collection";
import type { IconName } from "@narsil-cms/plugins/icons";

export type Block = {
  elements: BlockElement[];
  handle: string;
  id: number;
  identifier: string;
  name: string;
};

export type BlockElement = {
  blocks: Block[];
  conditions: BlockElementCondition[];
  description: string | null;
  element: Block | Field;
  fields: Field[];
  handle: string | null;
  id: number;
  name: string | null;
  position: number;
  settings: Record<string, any> | null;
};

export type BlockElementCondition = {
  id: number;
  operator: string;
  owner_id: number;
  target_id: number;
  value: string;
};

export type Field = {
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
  description: string;
  form: (Block | Field)[];
  id: string;
  method: string;
  submit: string;
  title: string;
  url: string;
};

export type GroupedSelectOption = {
  [key: string]: any;
  icon?: IconName;
  identifier: string;
  label: string;
  optionLabel: string;
  options: SelectOption[];
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
