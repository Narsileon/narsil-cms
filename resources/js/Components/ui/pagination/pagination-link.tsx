import { ButtonProps, buttonVariants } from "@/Components/ui/button";
import { cn } from "@/Components/utils";

export type PaginationLinkProps = React.ComponentProps<"a"> &
  Pick<ButtonProps, "size"> & { isActive?: boolean };

function PaginationLink({
  className,
  isActive,
  size = "icon",
  ...props
}: PaginationLinkProps) {
  return (
    <a
      data-slot="pagination-link"
      data-active={isActive}
      className={cn(
        buttonVariants({
          variant: isActive ? "outline" : "ghost",
          size,
        }),
        className,
      )}
      aria-current={isActive ? "page" : undefined}
      {...props}
    />
  );
}

export default PaginationLink;
