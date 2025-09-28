import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

import { Card, Heading } from "@narsil-cms/blocks";
import {
  useMinLg,
  useMinMd,
  useMinSm,
  useMinXl,
} from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";
import type { Template } from "@narsil-cms/types";

type CollectionsProps = {
  templates: Template[];
};

function Collections({ templates }: CollectionsProps) {
  const isSm = useMinSm();
  const isMd = useMinMd();
  const isLg = useMinLg();
  const isXl = useMinXl();

  function getColumns() {
    let columns = isXl ? 5 : isLg ? 4 : isMd ? 3 : isSm ? 2 : 1;

    if (columns > templates.length) {
      columns = templates.length;
    }

    return columns;
  }

  const columns = getColumns();

  return (
    <div className="flex min-h-full w-full items-center justify-center">
      <div
        className={cn(
          "grid gap-6 p-6",
          columns === 2 && "grid-cols-2",
          columns === 3 && "grid-cols-3",
          columns === 4 && "grid-cols-4",
          columns === 5 && "grid-cols-5",
        )}
      >
        {templates.map((template) => {
          return (
            <Card
              className="aspect-square h-48 w-48 cursor-pointer shadow-lg"
              contentProps={{
                className:
                  "p-0 h-full w-full hover:bg-accent hover:text-accent-foreground transition-all duration-300",
              }}
              key={template.handle}
            >
              <Link
                className="flex h-full w-full items-center justify-center text-center"
                href={route("collections.index", template.handle)}
              >
                <Heading level="h2" variant="h5">
                  {template.name}
                </Heading>
              </Link>
            </Card>
          );
        })}
      </div>
    </div>
  );
}

export default Collections;
