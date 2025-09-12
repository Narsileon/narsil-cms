import {
  type ColumnDef,
  type ColumnOrderState,
  type VisibilityState,
} from "@tanstack/react-table";

import { type IconName } from "@narsil-cms/plugins/icons";

export type Bookmark = {
  id: number;
  name: string;
  url: string;
};

export type DataTableCollection<T = any> = {
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

export type LaravelNavigationItem = {
  href: string;
  icon?: IconName;
  label: string;
  method?: string;
  modal?: boolean;
};

export type LaravelPaginationLinks = {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
};

export type LaravelPaginationMeta = {
  current_page: number;
  from: number | null;
  last_page: number;
  links: {
    url: string | null;
    label: string;
    active: boolean;
  }[];
  path: string;
  per_page: number;
  to: number | null;
  total: number;
};

export type RouteNames = {
  create?: string;
  destroy?: string;
  destroyMany?: string;
  edit?: string;
  index?: string;
  params: Record<string, any>;
  replicate?: string;
  replicateMany?: string;
  show?: string;
  store?: string;
  update?: string;
};
