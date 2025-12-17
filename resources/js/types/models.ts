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

export type Entity = Model & {
  blocks: EntityBlock[];
};

export type EntityBlock = Model & {
  block: Block;
  children: EntityBlock[];
  fields: EntityBlockField[];
  uuid: string;
};

export type EntityBlockField = Model & {
  field: Field;
  value: string;
  uuid: string;
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
  required: boolean;
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
