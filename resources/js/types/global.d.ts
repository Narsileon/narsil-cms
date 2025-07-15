import { DynamicIcon } from "lucide-react/dynamic";
import type { IconName } from "lucide-react/dynamic";
import type {
  ColumnDef,
  ColumnOrderState,
  VisibilityState,
} from "@tanstack/react-table";

type CategoriesCollection = {
  data: {
    id: number;
    label: string;
  }[];
  meta: {
    routes: RouteNames;
    title: string;
  };
};

type DataTableCollection<T = any> = {
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

type LaravelForm = {
  action: string;
  id: string;
  content: LaravelFormInput[];
  method: string;
  submit: string;
};

type LaravelFormInput = {
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

type LaravelNavigationItem = {
  href: string;
  icon?: IconName;
  label: string;
  method?: string;
  modal?: boolean;
};

type LaravelPaginationLinks = {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
};

type LaravelPaginationMeta = {
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

type RouteNames = {
  create?: string;
  destroy?: string;
  edit?: string;
  index?: string;
  show?: string;
  store?: string;
  update?: string;
};

type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
