import { type IconName } from "@narsil-cms/repositories/icons";
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
  elements: StructureHasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  label: string;
  virtual: boolean;
};

export type Condition = {
  handle: number;
  operator: string;
  value: string;
};

export type Bookmark = Model & {
  name: string;
  url: string;
  uuid: string;
};

export type Entity = Model & {
  nodes: EntityNode[];
};

export type EntityNode = Model & {
  children: EntityNode[];
  uuid: string;
};

export type Field = {
  blocks: Block[];
  class_name: string;
  description: string | null;
  handle: string;
  id: number;
  identifier: string;
  label: string;
  placeholder: string;
  options: FieldOption[];
  required: boolean;
  translatable: boolean;
} & FieldType;

export type FieldOption = {
  id: number;
  label: string;
  value: string;
} & FieldType;

export type Fieldset = {
  collapsible: boolean;
  elements: FormHasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  label: string;
};

export type Form = Model & {
  handle: string;
  id: number;
  name: string;
};

export type FormHasElement = HasElement & {
  element_type: "Narsil\\Models\\Forms\\Fieldset" | "Narsil\\Models\\Forms\\Input";
  element: Fieldset | Input;
};

export type FormTab = Model & {
  description: string;
  elements?: FormHasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  label: string;
};

export type HasElement = Model & {
  conditions?: Condition[];
  element_id: number;
  handle: string;
  id: number;
  label: string;
  position: number;
  required: boolean;
  translatable: boolean;
  width: number;
};

export type HostLocale = Model & {
  country: string;
  languages: HostLocaleLanguage[];
};

export type HostLocaleLanguage = Model & {
  display_language: string;
  language: string;
};

export type Input = {
  blocks: Block[];
  class_name: string;
  description: string | null;
  handle: string;
  id: number;
  identifier: string;
  label: string;
  placeholder: string;
  options: FieldOption[];
  required: boolean;
  translatable: boolean;
} & FieldType;

export type SitePage = Model & {
  content: string[];
  entities: Record<string, Entity>;
  meta_description: string;
  open_graph_description: string;
  open_graph_image: string;
  open_graph_title: string;
  open_graph_type: string;
  title: string;
  urls: SiteUrl[];
};

export type SiteUrl = Model & {
  host_locale_language: HostLocaleLanguage;
  url: string;
};

export type StructureHasElement = HasElement & {
  element_type: "Narsil\\Models\\Structures\\Block" | "Narsil\\Models\\Structures\\Field";
  element: Block | Field;
};

export type Template = Model & {
  handle: string;
  id: number;
  name: string;
};

export type TemplateTab = Model & {
  elements?: StructureHasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  label: string;
};

export type User = Model & {
  id: number;
  first_name: string;
  full_name: string;
  last_name: string;
};
