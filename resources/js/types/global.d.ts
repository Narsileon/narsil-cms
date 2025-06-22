export type GlobalProps = {
  breadcrumbs: BreadcrumbType;
  shared: {
    locale: string;
    locales: string[];
    redirect: {
      success: string;
      error: string;
    };
    translations: Record<string, string>;
  };
};

export type SelectOption = {
  label: string;
  options?: SelectOption[];
  [key: string]: any;
};
