import * as React from "react";

type BreadcrumbRootProps = React.ComponentProps<"nav"> & {};

function BreadcrumbRoot({ ...props }: BreadcrumbRootProps) {
  return <nav data-slot="breadcrumb-root" aria-label="breadcrumb" {...props} />;
}

export default BreadcrumbRoot;
