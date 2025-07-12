import { Link } from "@inertiajs/react";
import { Tooltip } from "@/components/ui/tooltip";
import useTranslationsStore from "@/stores/translations-store";
import {
  ChevronLeft,
  ChevronRight,
  ChevronsLeft,
  ChevronsRight,
} from "lucide-react";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
} from "@/components/ui/pagination";
import type {
  LaravelPaginationLinks,
  LaravelPaginationMeta,
} from "@/types/global";

type DataTablePaginationProps = React.ComponentProps<typeof Pagination> & {
  links: LaravelPaginationLinks;
  metaLinks: LaravelPaginationMeta["links"];
};

function DataTablePagination({
  links,
  metaLinks,
  ...props
}: DataTablePaginationProps) {
  const { trans } = useTranslationsStore();

  return (
    <Pagination {...props}>
      <PaginationContent>
        <Tooltip tooltip={trans("accessibility.page_first", "First page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={trans("accessibility.page_first", "First page")}
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
        <Tooltip
          tooltip={trans("accessibility.page_previous", "Previous page")}
        >
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.prev === null}>
              <Link
                aria-label={trans(
                  "accessibility.page_previous",
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
            <PaginationEllipsis key={index} />
          );
        })}
        <Tooltip tooltip={trans("accessibility.page_next", "Next page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={trans("accessibility.page_next", "Next page")}
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
        <Tooltip tooltip={trans("accessibility.page_last", "Last page")}>
          <PaginationItem>
            <PaginationLink asChild={true} isDisabled={links.next === null}>
              <Link
                aria-label={trans("accessibility.page_last", "Last page")}
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
