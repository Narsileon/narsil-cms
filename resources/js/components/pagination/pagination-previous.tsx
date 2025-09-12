import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import PaginationLink from "./pagination-link";

type PaginationPreviousProps = React.ComponentProps<typeof PaginationLink> & {};

function PaginationPrevious({ className, ...props }: PaginationPreviousProps) {
  return (
    <PaginationLink
      className={cn("px-2.5 sm:pl-2.5", className)}
      aria-label="Go to previous page"
      size="default"
      {...props}
    >
      <Icon name="chevron-left" />
      <span className="hidden sm:block">Previous</span>
    </PaginationLink>
  );
}

export default PaginationPrevious;
