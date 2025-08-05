import * as React from "react";

type BreadcrumbProps = React.ComponentProps<"nav"> & {};

function Breadcrumb({ ...props }: BreadcrumbProps) {
  return <nav data-slot="breadcrumb" aria-label="breadcrumb" {...props} />;
}

export default Breadcrumb;
