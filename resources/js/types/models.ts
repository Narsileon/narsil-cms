import { IconName } from "@narsil-cms/plugins/icons";

import { FieldType } from "./fields";

export type Block = {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
  sets: Block[];
};

export type Field = {
  blocks: Block[];
  description: string | null;
  handle: string;
  id: number;
  identifier: string;
  name: string;
} & FieldType;

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

export type Template = {
  handle: string;
  id: number;
  name: string;
};

export type TemplateSection = {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
  sets: Block[];
};
