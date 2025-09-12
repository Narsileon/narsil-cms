import { Link } from "@inertiajs/react";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationRoot,
} from "@narsil-cms/components/pagination";

export type LaravelPaginationLinks = {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
};

export type LaravelPaginationMeta = {
  current_page: number;
  from: number | null;
  last_page: number;
  links: {
    url: string | null;
    label: string;
    active: boolean;
  }[];
  path: string;
  per_page: number;
  to: number | null;
  total: number;
};

type PaginationProps = React.ComponentProps<typeof PaginationRoot> & {
  links: LaravelPaginationLinks;
  metaLinks?: LaravelPaginationMeta["links"];
};

function Pagination({ links, metaLinks, ...props }: PaginationProps) {
  const { trans } = useLabels();

  return (
    <PaginationRoot {...props}>
      <PaginationContent>
        <Tooltip tooltip={trans("accessibility.first_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-r-none"
              asChild={true}
              disabled={links.prev === null}
            >
              <Link
                aria-label={trans("accessibility.first_page", "First page")}
                as="button"
                href={links.first}
                preserveScroll={true}
                preserveState={true}
              >
                <Icon name="chevrons-left" />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={trans("accessibility.previous_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-none"
              asChild={true}
              disabled={links.prev === null}
            >
              <Link
                aria-label={trans(
                  "accessibility.previous_page",
                  "Previous page",
                )}
                as="button"
                href={links.prev ?? ""}
                preserveScroll={true}
                preserveState={true}
              >
                <Icon name="chevron-left" />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        {metaLinks?.slice(1, -1).map((link, index) => {
          return link.url ? (
            <PaginationItem key={index}>
              <PaginationLink
                className="rounded-none"
                asChild={true}
                active={link.active}
              >
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
            <PaginationItem>
              <PaginationLink
                className="rounded-none"
                asChild={true}
                disabled={true}
              >
                <PaginationEllipsis
                  className="border bg-accent"
                  label={trans("accessibility.more_pages", "More pages")}
                  key={index}
                />
              </PaginationLink>
            </PaginationItem>
          );
        })}
        <Tooltip tooltip={trans("accessibility.next_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-none"
              asChild={true}
              disabled={links.next === null}
            >
              <Link
                aria-label={trans("accessibility.next_page", "Next page")}
                as="button"
                href={links.next ?? ""}
                preserveScroll={true}
                preserveState={true}
              >
                <Icon name="chevron-right" />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={trans("accessibility.last_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-l-none"
              asChild={true}
              disabled={links.next === null}
            >
              <Link
                aria-label={trans("accessibility.last_page", "Last page")}
                as="button"
                href={links.last}
                preserveScroll={true}
                preserveState={true}
              >
                <Icon name="chevrons-right" />
              </Link>
            </PaginationLink>
          </PaginationItem>
        </Tooltip>
      </PaginationContent>
    </PaginationRoot>
  );
}

export default Pagination;
