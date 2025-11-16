import { type IconName } from "@narsil-cms/plugins/icons";
import type { FieldType } from "@narsil-cms/types";

export type Model = {
  created_at?: string;
  id: number;
  updated_at?: string;
  published_revision?: Model;
  saved?: boolean;
  draft?: Model;
  [key: string]: unknown;
};

export type Block = {
  collapsible: boolean;
  elements: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
};

export type Bookmark = Model & {
  id: number;
  name: string;
  url: string;
};

export type Field = {
  blocks: Block[];
  class_name: string;
  description: string | null;
  handle: string;
  id: number;
  identifier: string;
  name: string;
  options: FieldOption[];
  translatable: boolean;
} & FieldType;

export type FieldOption = {
  id: number;
  label: string;
  value: string;
} & FieldType;

export type HasElement = Model & {
  element_id: number;
  element_type: "Narsil\\Models\\Elements\\Block" | "Narsil\\Models\\Elements\\Field";
  element: Block | Field;
  handle: string;
  id: number;
  name: string;
  position: number;
  width: number;
};

export type Template = Model & {
  handle: string;
  id: number;
  name: string;
};

export type TemplateSection = Model & {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
};

export type User = Model & {
  id: number;
  first_name: string;
  full_name: string;
  last_name: string;
};
