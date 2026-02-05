import { Link } from "@inertiajs/react";
import { CardContent, CardRoot } from "@narsil-ui/components/card";
import { Heading } from "@narsil-ui/components/heading";
import { useMinLg, useMinMd, useMinSm, useMinXl } from "@narsil-ui/hooks/use-breakpoints";
import { cn } from "@narsil-ui/lib/utils";

type Item = {
  href: string;
  name: string;
};

type CollectionsProps = {
  items: Item[];
};

function Collections({ items }: CollectionsProps) {
  const isSm = useMinSm();
  const isMd = useMinMd();
  const isLg = useMinLg();
  const isXl = useMinXl();

  function getColumns() {
    let columns = isXl ? 5 : isLg ? 4 : isMd ? 3 : isSm ? 2 : 1;

    if (columns > items.length) {
      columns = items.length;
    }

    return columns;
  }

  const columns = getColumns();

  return (
    <div className="flex min-h-full w-full animate-in items-center justify-center fade-in-0">
      <div
        className={cn(
          "grid gap-6 p-6",
          columns === 2 && "grid-cols-2",
          columns === 3 && "grid-cols-3",
          columns === 4 && "grid-cols-4",
          columns === 5 && "grid-cols-5",
        )}
      >
        {items.map((item, index) => {
          return (
            <CardRoot className="aspect-square h-48 w-48 cursor-pointer shadow-lg" key={index}>
              <CardContent className="h-full w-full p-0 transition-all hover:bg-accent hover:text-accent-foreground">
                <Link
                  className="flex h-full w-full items-center justify-center text-center"
                  href={item.href}
                >
                  <Heading level="h2" variant="h5">
                    {item.name}
                  </Heading>
                </Link>
              </CardContent>
            </CardRoot>
          );
        })}
      </div>
    </div>
  );
}

export default Collections;
