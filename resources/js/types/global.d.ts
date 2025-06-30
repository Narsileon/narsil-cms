import { ColumnDef } from "@tanstack/react-table";
import { DynamicIcon } from "lucide-react/dynamic";
import React from "react";

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

export type LaravelCollection<T = any> = LaravelPagination & {
  columns: ColumnDef<T>;
  columnVisibility: string[];
  data: T[];
  links: LaravelPaginationLinks;
  meta: LaravelPaginationMeta;
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
