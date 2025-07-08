import { ChevronLeftIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import PaginationLink from "./pagination-link";

type PaginationPreviousProps = React.ComponentProps<typeof PaginationLink> & {};

function PaginationPrevious({ className, ...props }: PaginationPreviousProps) {
  return (
    <PaginationLink
      className={cn("gap-1 px-2.5 sm:pl-2.5", className)}
      aria-label="Go to previous page"
      size="default"
      {...props}
    >
      <ChevronLeftIcon />
      <span className="hidden sm:block">Previous</span>
    </PaginationLink>
  );
}

export default PaginationPrevious;
