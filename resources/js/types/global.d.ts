export type GlobalProps = {
  auth: {
    email: string;
    first_name: string | undefined | null;
    last_name: string | undefined | null;
    two_factor_confirmed_at: string | null;
  };
  breadcrumbs: BreadcrumbType;
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
  data: T[];
  path: string;
};

export type LaravelPagination = {
  current_page: number;
  first_page_url: string;
  from: number | null;
  last_page: number;
  last_page_url: string;
  links: {
    url: string | null;
    label: string;
    active: boolean;
  }[];
  next_page_url: string | null;
  per_page: number;
  prev_page_url: string | null;
  to: number | null;
  total: number;
};

export type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
