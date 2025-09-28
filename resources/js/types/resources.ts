import { type InertiaLinkProps } from "@inertiajs/react";
import {
  type ColumnDef,
  type ColumnOrderState,
  type VisibilityState,
} from "@tanstack/react-table";

import {
  type LaravelPaginationLinks,
  type LaravelPaginationMeta,
} from "@narsil-cms/blocks/pagination";
import { type IconName } from "@narsil-cms/plugins/icons";

import { Block, Field, TemplateSection } from "./models";

export type BlockElementCondition = {
  id: number;
  operator: string;
  owner_id: number;
  target_id: number;
  value: string;
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

export type FormType = {
  action: string;
  description: string;
  id: string;
  layout: (Block | Field | TemplateSection)[];
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

export type MenuItem = {
  group?: string;
  href: string;
  icon?: IconName;
  label: string;
  method: InertiaLinkProps["method"];
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

export type UniqueIdentifier = string | number;
