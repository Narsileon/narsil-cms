export type GlobalProps = {
  auth: {
    email: string;
    first_name: string | undefined | null;
    last_name: string | undefined | null;
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

export type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
