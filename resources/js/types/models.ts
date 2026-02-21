import { type IconName } from "@narsil-ui/registries/icons";

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
  elements: Element[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  label: string;
  virtual: boolean;
};

export type Condition = {
  handle: string;
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
  description: string;
  handle: string;
  id: number;
  identifier: string;
  label: string;
  placeholder: string;
  options: FieldOption[];
};

export type FieldOption = {
  id: number;
  label: string;
  value: string;
};

export type Element = Model & {
  base: Block | Field;
  base_id: number;
  base_type: "Narsil\\Cms\\Models\\Collections\\Block" | "Narsil\\Cms\\Models\\Collections\\Field";
  class_name: string;
  conditions?: Condition[];
  description?: string;
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

export type TemplateTab = Model & {
  elements?: Element[];
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
