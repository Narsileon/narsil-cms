import { DynamicIcon } from "lucide-react/dynamic";
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
  };
  config: {
    sidebar: {
      content: NavigationOption[];
    };
  };
  redirect: {
    error: string;
    info: string;
    success: string;
    warning: string;
  };
  shared: {
    locale: string;
    locales: string[];
    translations: Record<string, string>;
  };
};

type CategoriesCollection = {
  data: {
    destroy_href: string;
    edit_href: string;
    id: number;
    label: string;
  }[];
  meta: {
    create_href: string;
  };
};

type DataTableCollection<T = any> = {
  columns: ColumnDef<T>[];
  columnOrder: ColumnOrderState;
  columnVisibility: VisibilityState;
  data: T[];
  links: LaravelPaginationLinks;
  meta: LaravelPaginationMeta & {
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
  options?: SelectOption[];
  required?: boolean;
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
