import { IconName } from "@narsil-cms/plugins/icons";

import { FieldType } from "./fields";

export type BaseModel = {
  id: number;
  [key: string]: unknown;
};

export type Block = BaseModel & {
  collapsible: boolean;
  elements: HasElement[];
  handle: string;
  icon?: IconName;
  identifier: string;
  name: string;
  sets: Block[];
};

export type Bookmark = BaseModel & {
  name: string;
  url: string;
};

export type Field = BaseModel & {
  blocks: Block[];
  description: string | null;
  handle: string;
  identifier: string;
  name: string;
} & FieldType;

export type HasElement = BaseModel & {
  element_id: number;
  element_type:
    | "Narsil\\Models\\Elements\\Block"
    | "Narsil\\Models\\Elements\\Field";
  element: Block | Field;
  handle: string;
  name: string;
  position: number;
  width: number;
};

export type Template = BaseModel & {
  handle: string;
  name: string;
};

export type TemplateSection = BaseModel & {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  identifier: string;
  name: string;
  sets: Block[];
};
