import { Fragment, useMemo } from "react";
import { Link } from "@inertiajs/react";
import { replace } from "lodash";
import useTranslationsStore from "@/stores/translations-store";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";

type AppBreadcrumbProps = React.ComponentProps<typeof Breadcrumb> & {};

function AppBreadcrumb({ ...props }: AppBreadcrumbProps) {
  const { trans } = useTranslationsStore();

  const pathname = window.location.pathname;

  const items = useMemo(() => {
    const parts = pathname.split("/").filter(Boolean);

    let path = "";

    return parts.map((part) => {
      path += `/${part}`;

      return {
        slug: replace(part, "-", "_"),
        path: path,
      };
    });
  }, [pathname]);

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
