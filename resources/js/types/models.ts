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
  sets: Block[];
};

export type Bookmark = Model & {
  id: number;
  name: string;
  url: string;
};

export type Field = {
  blocks: Block[];
  description: string | null;
  handle: string;
  id: number;
  identifier: string;
  name: string;
  translatable: boolean;
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
  sets: Block[];
};
