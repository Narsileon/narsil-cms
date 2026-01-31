import { type ComponentProps } from "react";

function BreadcrumbRoot({ ...props }: ComponentProps<"nav">) {
  return <nav data-slot="breadcrumb-root" aria-label="Breadcrumb" role="navigation" {...props} />;
}

export default BreadcrumbRoot;
