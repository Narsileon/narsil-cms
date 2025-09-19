import {
  type ColumnDef,
  type ColumnOrderState,
  type VisibilityState,
} from "@tanstack/react-table";

import {
  LaravelPaginationLinks,
  LaravelPaginationMeta,
} from "@narsil-cms/blocks/pagination";
import { type IconName } from "@narsil-cms/plugins/icons";

export type Block = {
  elements?: HasElement[];
  handle: string;
  icon?: IconName;
  id: number;
  identifier: string;
  name: string;
  sets: Block[];
};

export type BlockElementCondition = {
  id: number;
  operator: string;
  owner_id: number;
  target_id: number;
  value: string;
};

export type Bookmark = {
  id: number;
  name: string;
  url: string;
};

export type DataTableCollection<T = unknown> = {
  columns: ColumnDef<T>[];
  columnOrder: ColumnOrderState;
  columnVisibility: VisibilityState;
  data: T[];
  links: LaravelPaginationLinks;
  meta: LaravelPaginationMeta & {
    id: string;
    selectable?: boolean;
    routes: RouteNames;
    title: string;
  };
};

export type DataTableFilterCollection = {
  data: {
    id: number;
    label: string;
  }[];
  meta: {
    addLabel: string;
    routes: RouteNames;
    title: string;
  };
};

export type Field<T = Record<string, unknown>> = {
  blocks: Block[];
  description: string | null;
  handle: string;
  id: number;
  name: string;
  settings: T;
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
  [key: string]: unknown;
  icon?: IconName;
  identifier: string;
  label: string;
  optionLabel: string;
  options: (GroupedSelectOption | SelectOption)[];
  optionValue: string;
  routes: RouteNames;
  value: unknown;
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

export type LaravelNavigationItem = {
  href: string;
  icon?: IconName;
  label: string;
  method?: string;
  modal?: boolean;
};

export type RouteNames = {
  create?: string;
  destroy?: string;
  destroyMany?: string;
  edit?: string;
  index?: string;
  params: Record<string, unknown>;
  replicate?: string;
  replicateMany?: string;
  show?: string;
  store?: string;
  update?: string;
};

export type SelectOption = {
  [key: string]: unknown;
  icon?: IconName;
  label: string;
  value: UniqueIdentifier;
};

export type Template = {
  handle: string;
  id: number;
  name: string;
};

export type UniqueIdentifier = string | number;
