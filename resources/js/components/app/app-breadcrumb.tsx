import { Fragment } from "react";
import { Link } from "@inertiajs/react";
import { useNavigation } from "@narsil-cms/hooks/use-props";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@narsil-cms/components/ui/breadcrumb";

type AppBreadcrumbProps = React.ComponentProps<typeof Breadcrumb> & {};

function AppBreadcrumb({ ...props }: AppBreadcrumbProps) {
  const { breadcrumb } = useNavigation();

  return (
    <Breadcrumb {...props}>
      <BreadcrumbList>
        {breadcrumb.map((item, index) => {
          const isLast = index === breadcrumb.length - 1;

          return isLast ? (
            <BreadcrumbItem key={index}>
              <BreadcrumbPage>{item.label}</BreadcrumbPage>
            </BreadcrumbItem>
          ) : (
            <Fragment key={index}>
              <BreadcrumbItem>
                <BreadcrumbLink asChild>
                  <Link href={item.href}>{item.label}</Link>
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
