import { Link } from "@inertiajs/react";
import { Fragment, useMemo } from "react";
import useTranslationsStore from "@/stores/translations-store";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import type { BreadcrumbProps } from "@/components/ui/breadcrumb";

type AppBreadcrumbProps = BreadcrumbProps & {};

function AppBreadcrumb({ ...props }: AppBreadcrumbProps) {
  const { trans } = useTranslationsStore();

  const pathname = window.location.pathname;

  const items = useMemo(() => {
    const parts = pathname.split("/").filter(Boolean);

    let path = "";

    return parts.map((part) => {
      path += `/${part}`;

      return {
        slug: part,
        path: path,
      };
    });
  }, [pathname]);

  if (items.length === 0) {
    return null;
  }

  return (
    <Breadcrumb {...props}>
      <BreadcrumbList>
        {items.map((item, index) => {
          const isLast = index === items.length - 1;
          return isLast ? (
            <BreadcrumbItem key={index}>
              <BreadcrumbPage>
                {trans(`ui.${item.slug}`, item.slug)}
              </BreadcrumbPage>
            </BreadcrumbItem>
          ) : (
            <Fragment key={index}>
              <BreadcrumbItem>
                <BreadcrumbLink asChild>
                  <Link href={item.path}>
                    {trans(`ui.${item.slug}`, item.slug)}
                  </Link>
                </BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator />
            </Fragment>
          );
        })}
      </BreadcrumbList>
    </Breadcrumb>
  );
}

export default AppBreadcrumb;
