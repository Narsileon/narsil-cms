import { Link } from "@inertiajs/react";
import { Icon } from "@narsil-cms/blocks/icon";
import {
  type LaravelPaginationLinks,
  type LaravelPaginationMetaLink,
} from "@narsil-cms/blocks/pagination";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationRoot,
} from "@narsil-cms/components/pagination";
import { type ComponentProps } from "react";

type PaginationProps = ComponentProps<typeof PaginationRoot> & {
  contentProps?: Partial<ComponentProps<typeof PaginationContent>>;
  links: LaravelPaginationLinks;
  metaLinks?: LaravelPaginationMetaLink[];
};

function Pagination({ contentProps, links, metaLinks, ...props }: PaginationProps) {
  const { trans } = useLocalization();

  const firstPageLabel = trans("accessibility.first_page");
  const prevPageLabel = trans("accessibility.previous_page");
  const nextPageLabel = trans("accessibility.next_page");
  const lastPageLabel = trans("accessibility.last_page");

  return (
    <PaginationRoot {...props}>
      <PaginationContent {...contentProps}>
        <PaginationItem>
          <Tooltip tooltip={firstPageLabel}>
            <PaginationLink
              aria-label={firstPageLabel}
              className="rounded-r-none"
              disabled={links.prev === null}
              render={
                <Link as="button" href={links.first} preserveScroll={true} preserveState={true}>
                  <Icon name="chevrons-left" />
                </Link>
              }
            />
          </Tooltip>
        </PaginationItem>
        <PaginationItem>
          <Tooltip tooltip={prevPageLabel}>
            <PaginationLink
              aria-label={prevPageLabel}
              className="rounded-none"
              disabled={links.prev === null}
              render={
                <Link
                  as="button"
                  href={links.prev ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <Icon name="chevron-left" />
                </Link>
              }
            />
          </Tooltip>
        </PaginationItem>
        {metaLinks?.slice(1, -1).map((link, index) => {
          return link.url ? (
            <PaginationItem key={index}>
              <PaginationLink
                className="rounded-none"
                active={link.active}
                render={
                  <Link as="button" href={link.url} preserveScroll={true} preserveState={true}>
                    {link.label}
                  </Link>
                }
              />
            </PaginationItem>
          ) : (
            <PaginationItem>
              <PaginationLink className="rounded-none" disabled={true}>
                <PaginationEllipsis className="border bg-accent" key={index} />
              </PaginationLink>
            </PaginationItem>
          );
        })}
        <PaginationItem>
          <Tooltip tooltip={nextPageLabel}>
            <PaginationLink
              aria-label={nextPageLabel}
              className="rounded-none"
              disabled={links.next === null}
              render={
                <Link
                  as="button"
                  href={links.next ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <Icon name="chevron-right" />
                </Link>
              }
            />
          </Tooltip>
        </PaginationItem>
        <PaginationItem>
          <Tooltip tooltip={lastPageLabel}>
            <PaginationLink
              aria-label={lastPageLabel}
              className="rounded-none"
              disabled={links.next === null}
              render={
                <Link
                  as="button"
                  href={links.last ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <Icon name="chevrons-right" />
                </Link>
              }
            />
          </Tooltip>
        </PaginationItem>
      </PaginationContent>
    </PaginationRoot>
  );
}

export default Pagination;
