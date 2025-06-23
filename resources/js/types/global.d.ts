export type GlobalProps = {
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
