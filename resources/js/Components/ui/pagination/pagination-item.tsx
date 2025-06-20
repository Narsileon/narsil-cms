export type PaginationItemProps = React.ComponentProps<"li"> & {};

function PaginationItem({ ...props }: React.ComponentProps<"li">) {
  return <li data-slot="pagination-item" {...props} />;
}

export default PaginationItem;
