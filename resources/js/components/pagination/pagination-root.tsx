type PaginationRootProps = React.ComponentProps<"nav"> & {};

function PaginationRoot({ ...props }: PaginationRootProps) {
  return (
    <nav
      data-slot="pagination-root"
      aria-label="pagination"
      role="navigation"
      {...props}
    />
  );
}

export default PaginationRoot;
