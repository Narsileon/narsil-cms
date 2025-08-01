import type { IconName } from "lucide-react/dynamic";
import type {
  ColumnDef,
  ColumnOrderState,
  VisibilityState,
} from "@tanstack/react-table";

export type DataTableCollection<T = any> = {
  columns: ColumnDef<T>[];
  columnOrder: ColumnOrderState;
  columnVisibility: VisibilityState;
  data: T[];
  links: LaravelPaginationLinks;
  meta: LaravelPaginationMeta & {
    id: string;
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
  edit?: string;
  index?: string;
  show?: string;
  store?: string;
  update?: string;
};
