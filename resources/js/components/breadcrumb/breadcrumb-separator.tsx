import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";

type BreadcrumbSeparatorProps = React.ComponentProps<"li"> & {};

function BreadcrumbSeparator({
  children,
  className,
  ...props
}: BreadcrumbSeparatorProps) {
  return (
    <li
      data-slot="breadcrumb-separator"
      className={cn("[&>svg]:size-3.5", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      {children ?? <Icon name="chevron-right" />}
    </li>
  );
}

export default BreadcrumbSeparator;
