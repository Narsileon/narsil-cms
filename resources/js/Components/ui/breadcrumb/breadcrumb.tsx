export type BreadcrumbProps = React.ComponentProps<"nav"> & {};

function Breadcrumb({ ...props }: BreadcrumbProps) {
  return <nav aria-label="breadcrumb" data-slot="breadcrumb" {...props} />;
}

export default Breadcrumb;
