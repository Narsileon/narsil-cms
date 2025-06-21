export type GlobalProps = {
  breadcrumbs: BreadcrumbType;
  shared: {
    localization: {
      locale: string;
      locales: string[];
      translations: Record<string, string>;
    };
    redirect: {
      success: string;
      error: string;
    };
  };
};
