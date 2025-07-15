import { Link } from "@inertiajs/react";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
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
import type { LaravelPaginationLinks, LaravelPaginationMeta } from "@/types";

type DataTablePaginationProps = React.ComponentProps<typeof Pagination> & {
  links: LaravelPaginationLinks;
  metaLinks: LaravelPaginationMeta["links"];
};

function DataTablePagination({
  links,
  metaLinks,
  ...props
}: DataTablePaginationProps) {
  const { getLabel } = useLabels();

  return (
    <Pagination {...props}>
      <PaginationContent>
        <Tooltip tooltip={getLabel("accessibility.first_page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={getLabel("accessibility.first_page", "First page")}
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
        <Tooltip tooltip={getLabel("accessibility.previous_page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={getLabel(
                  "accessibility.previous_page",
                  "Previous page",
                )}
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
            <PaginationEllipsis
              label={getLabel("accessibility.more_pages", "More pages")}
              key={index}
            />
          );
        })}
        <Tooltip tooltip={getLabel("accessibility.next_page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={getLabel("accessibility.next_page", "Next page")}
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
        <Tooltip tooltip={getLabel("accessibility.last_page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={getLabel("accessibility.last_page", "Last page")}
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
