import type { IconName } from "lucide-react/dynamic";
import type {
  ColumnDef,
  ColumnOrderState,
  VisibilityState,
} from "@tanstack/react-table";

export type CategoriesCollection = {
  data: {
    id: number;
    label: string;
  }[];
  meta: {
    routes: RouteNames;
    title: string;
  };
};

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

export type LaravelForm = {
  action: string;
  id: string;
  content: LaravelFormInput[];
  method: string;
  submit: string;
};

export type LaravelFormInput = {
  autoComplete?: string;
  column?: boolean;
  description?: string;
  id: string;
  label: string;
  max?: number;
  min?: number;
  options?: SelectOption[];
  placeholder?: string;
  required?: boolean;
  step?: number;
  type?: string;
  value: any;
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

export type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
