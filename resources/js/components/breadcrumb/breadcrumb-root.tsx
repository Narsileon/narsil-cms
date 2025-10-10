import { type ComponentProps } from "react";

type BreadcrumbRootProps = ComponentProps<"nav">;

function BreadcrumbRoot({ ...props }: BreadcrumbRootProps) {
  return <nav data-slot="breadcrumb-root" aria-label="Breadcrumb" role="navigation" {...props} />;
}

export default BreadcrumbRoot;
