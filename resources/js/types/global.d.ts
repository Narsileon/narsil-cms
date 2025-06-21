export type GlobalProps = {
  breadcrumbs: BreadcrumbType;
  shared: {
    locale: string;
    redirect: {
      success: string;
      error: string;
    };
    translations: Record<string, string>;
  };
};
