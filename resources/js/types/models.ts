import { IconName } from "@narsil-cms/plugins/icons";

import { FieldType } from "./fields";

export type Model = {
  created_at?: string;
  id: number;
  updated_at?: string;
  [key: string]: unknown;
};

export type Block = Model & {
  collapsible: boolean;
  elements: HasElement[];
  handle: string;
  icon?: IconName;
  identifier: string;
  name: string;
  sets: Block[];
};

export type Bookmark = Model & {
  name: string;
  url: string;
};

export type Field = Model & {
  blocks: Block[];
  description: string | null;
  handle: string;
  identifier: string;
  name: string;
} & FieldType;

export type HasElement = Model & {
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

export type Template = Model & {
  handle: string;
  name: string;
};

export type TemplateSection = Model & {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  identifier: string;
  name: string;
  sets: Block[];
};
