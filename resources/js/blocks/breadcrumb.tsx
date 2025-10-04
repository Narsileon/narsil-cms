import { Link } from "@inertiajs/react";
import { Fragment, type ComponentProps } from "react";

import {
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbRoot,
  BreadcrumbSeparator,
} from "@narsil-cms/components/breadcrumb";
import { useNavigation } from "@narsil-cms/hooks/use-props";

type BreadcrumbProps = ComponentProps<typeof BreadcrumbRoot>;

function Breadcrumb({ ...props }: BreadcrumbProps) {
  const { breadcrumb } = useNavigation();

  return (
    <BreadcrumbRoot {...props}>
      <BreadcrumbList>
        {breadcrumb.map((item, index) => {
          const isLast = index === breadcrumb.length - 1;

          return isLast ? (
            <BreadcrumbItem key={index}>
              <BreadcrumbPage>{item.label}</BreadcrumbPage>
            </BreadcrumbItem>
          ) : item.href ? (
            <Fragment key={index}>
              <BreadcrumbItem>
                <BreadcrumbLink asChild>
                  <Link href={item.href}>{item.label}</Link>
                </BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator />
            </Fragment>
          ) : (
            <Fragment key={index}>
              <BreadcrumbItem>{item.label}</BreadcrumbItem>
              <BreadcrumbSeparator />
            </Fragment>
          );
        })}
      </BreadcrumbList>
    </BreadcrumbRoot>
  );
}

export default Breadcrumb;
