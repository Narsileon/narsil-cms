import { type ComponentProps } from "react";

function BreadcrumbRoot({ ...props }: ComponentProps<"nav">) {
  return <nav data-slot="breadcrumb-root" aria-label="Breadcrumb" {...props} />;
}

export default BreadcrumbRoot;
