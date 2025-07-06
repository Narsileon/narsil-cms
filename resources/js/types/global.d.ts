import { DynamicIcon } from "lucide-react/dynamic";
import type {
  ColumnDef,
  ColumnOrderState,
  VisibilityState,
} from "@tanstack/react-table";

export type GlobalProps = {
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
    success: string;
    error: string;
  };
  shared: {
    locale: string;
    locales: string[];
    translations: Record<string, string>;
  };
};

export type LaravelCollection<T = any> = {
  columns: ColumnDef<T>[];
  columnOrder: ColumnOrderState;
  columnVisibility: VisibilityState;
  data: T[];
  links: LaravelPaginationLinks;
  meta: LaravelPaginationMeta;
};

export type LaravelForm = {
  action: string;
  inputs: LaravelFormInput[];
  method: string;
  submit: string;
  title: string;
};

export type LaravelFormInput = {
  autoComplete?: string;
  column?: boolean;
  description?: string;
  id: string;
  label: string;
  options?: SelectOption[];
  required?: boolean;
  type?: string;
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

export type NavigationOption = {
  route: string;
  icon: React.ComponentProps<typeof DynamicIcon>["name"];
  label: string;
  children?: NavigationOption[];
};

export type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
