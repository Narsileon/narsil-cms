import { DynamicIcon } from "lucide-react/dynamic";
import type { Theme } from "@/stores/theme-store";
import type {
  ColumnDef,
  ColumnOrderState,
  VisibilityState,
} from "@tanstack/react-table";

type GlobalProps = {
  auth: {
    email: string;
    first_name: string | undefined | null;
    last_name: string | undefined | null;
    two_factor_confirmed_at: string | null;
    configuration: {
      color: string;
      radius: number;
      theme: Theme;
    };
  };
  breadcrumb: {
    href: string;
    label: string;
  }[];
  labels: Record<string, string>;
  sidebar: {
    content: NavigationOption[];
    translations: Record<string, string>;
  };
  redirect: {
    error: string;
    info: string;
    success: string;
    warning: string;
  };
  shared: {
    locale: string;
  };
};

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
  inputs: LaravelFormInput[];
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

type NavigationOption = {
  route: string;
  icon: React.ComponentProps<typeof DynamicIcon>["name"];
  label: string;
  children?: NavigationOption[];
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
