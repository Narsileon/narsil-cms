import { Link } from "@inertiajs/react";
import { Tooltip } from "@/components/ui/tooltip";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
} from "@/components/ui/pagination";
import {
  ChevronLeft,
  ChevronRight,
  ChevronsLeft,
  ChevronsRight,
} from "lucide-react";
import type {
  LaravelPaginationLinks,
  LaravelPaginationMeta,
} from "@/types/global";

type DataTablePaginationProps = React.ComponentProps<typeof Pagination> & {
  ellipsisLabel?: string;
  firstPageLabel?: string;
  lastPageLabel?: string;
  links: LaravelPaginationLinks;
  metaLinks: LaravelPaginationMeta["links"];
  nextPageLabel?: string;
  previousPageLabel?: string;
};

function DataTablePagination({
  ellipsisLabel,
  firstPageLabel,
  lastPageLabel,
  links,
  metaLinks,
  nextPageLabel,
  previousPageLabel,
  ...props
}: DataTablePaginationProps) {
  return (
    <Pagination {...props}>
      <PaginationContent>
        <Tooltip tooltip={firstPageLabel ?? "First page"}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={firstPageLabel ?? "First page"}
                as="button"
                href={links.first}
                preserveScroll={true}
                preserveState={true}
              >
                <ChevronsLeft />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={previousPageLabel ?? "Previous page"}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={previousPageLabel ?? "Previous page"}
                as="button"
                href={links.prev ?? ""}
                preserveScroll={true}
                preserveState={true}
              >
                <ChevronLeft />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        {metaLinks.slice(1, -1).map((link, index) => {
          return link.url ? (
            <PaginationItem key={index}>
              <PaginationLink asChild={true} isActive={link.active}>
                <Link
                  as="button"
                  href={link.url}
                  preserveScroll={true}
                  preserveState={true}
                >
                  {link.label}
                </Link>
              </PaginationLink>
            </PaginationItem>
          ) : (
            <PaginationEllipsis ellipsisLabel={ellipsisLabel} key={index} />
          );
        })}
        <Tooltip tooltip={nextPageLabel ?? "Next page"}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={nextPageLabel ?? "Next page"}
                as="button"
                href={links.next ?? ""}
                preserveScroll={true}
                preserveState={true}
              >
                <ChevronRight />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={lastPageLabel ?? "Last page"}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={lastPageLabel ?? "Last page"}
                as="button"
                href={links.last}
                preserveScroll={true}
                preserveState={true}
              >
                <ChevronsRight />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
      </PaginationContent>
    </Pagination>
  );
}

export default DataTablePagination;
